<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/12/14
 * Time: 12:40 PM
 */

namespace Fitbase\Bundle\GamificationBundle\Helper;


use Fitbase\Bundle\GamificationBundle\Entity\GamificationUserEmotion;
use Fitbase\Bundle\GamificationBundle\Form\DataTransformer\GamificationEmotionDataTransformer;
use \Graph;
use \JpGraph\JpGraph;
use \UniversalTheme;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class GamificationHelper extends \Twig_Extension implements ContainerAwareInterface
{
    protected $container;

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('graph', array($this, 'graph')),
            new \Twig_SimpleFunction('image', array($this, 'image')),
            new \Twig_SimpleFunction('emotion', array($this, 'getEmotion')),
            new \Twig_SimpleFunction('answer', array($this, 'getAnswer')),
            new \Twig_SimpleFunction('feedback', array($this, 'getFeedback')),

        );
    }


    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('emotion', array($this, 'getEmotion')),
            new \Twig_SimpleFilter('feedback', array($this, 'getFeedback')),
            new \Twig_SimpleFilter('answer', array($this, 'getAnswer')),

        );
    }

    /**
     * Draw agraph image
     * @param null $statistic
     * @return string
     */
    public function graph($statistic = null)
    {
        if (empty($statistic)) {
            $statistic = array(
                array(
                    'date' => $this->container->get('datetime')->getDateTime('now'),
                    'count_point_total' => 0,
                )
            );
        }

        $dataMonthCacheArray = array();
        foreach ($statistic as $element) {

            if (isset($element['date'])) {
                if (($data = $element['date'])) {
                    $dateString = $this->container->get('translator')->trans($data->format("F"));
                    if (!isset($dataMonthCache[$dateString])) {
                        $dataMonthCacheArray[$dateString] = array();
                    }

                    array_push($dataMonthCacheArray[$dateString], (int)$element['count_point_total']);
                }
            }
        }

        $values = array();
        if (!empty($dataMonthCacheArray)) {
            foreach ($dataMonthCacheArray as $cache) {
                array_push($values, max($cache));
            }
        }

        JpGraph::load();
        JpGraph::module('line');
        JpGraph::module('bar');


        $graph = new Graph(335, 400, 'auto');
        $graph->SetScale("textlin");

        $graph->SetTheme(new UniversalTheme);
        $graph->SetMargin(50, 40, 40, 40);
        $graph->img->SetAngle(0);

        $graph->SetBox(false);

        $graph->ygrid->Show(false);
        $graph->ygrid->SetFill(false);
        $graph->xaxis->SetTickLabels(array_keys($dataMonthCacheArray));

        $graph->yaxis->HideLine(false);
        $graph->yaxis->HideTicks(false, false);

        $graph->SetBackgroundGradient('#FFFFFF', '#FFFFFF', GRAD_HOR, BGRAD_PLOT);

        $b1plot = new \BarPlot($values);
        $b1plot->SetFillGradient("#c0e3e8", "#FFFFFF", GRAD_HOR);
        $b1plot->SetWidth(60);
        $b1plot->SetWeight(0);
        $graph->Add($b1plot);

        $graph->Stroke(_IMG_HANDLER);

        //Start buffering
        ob_start();
        $graph->img->Stream();
        $image = ob_get_contents();
        ob_end_clean();

        return '<img style="width: 100%;" src="data:image/png;base64,' . base64_encode($image) . '"  />';
    }

    /**
     * Convert svg image to png
     * @param $content
     * @param int $width
     * @return null|string
     */
    public function image($content, $width = 400)
    {
        if (!strlen($content)) {
            return null;
        }

        $imagick = new \Imagick();
        $imagick->setBackgroundColor(new \ImagickPixel('transparent'));
        $imagick->readImageBlob('<?xml version="1.0" encoding="UTF-8" standalone="no"?>' . $content);
        $imagick->scaleImage($width, 0);
        $imagick->setImageFormat("png");

        return '<img style="width: ' . $width . 'px;" src="data:image/png;base64,' . base64_encode($imagick) . '"  />';
    }

    /**
     * Try to get emotion short-code
     * @param $emotion
     * @return null
     */
    public function getEmotion(GamificationUserEmotion $emotion)
    {
        if (($value = $emotion->getValue()) !== null) {
            $transformer = new GamificationEmotionDataTransformer();
            $imageString = '<img src="/image/smiles/%emotion%.png" width="40px"/>';
            if (($emotionString = $transformer->transform($value))) {
                return str_replace('%emotion%', $emotionString, $imageString);
            }
        }
        return null;
    }


    /**
     * Get user feedback from cache
     * @param $answer
     * @return null
     */
    public function getFeedback($answer)
    {
        if (($user = $this->container->get('user')->current())) {
            $entityManager = $this->container->get('entity_manager');
            $repositoryGamificationUserDialogFeedback = $entityManager->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUserDialogFeedback');

            if (($feedback = $repositoryGamificationUserDialogFeedback->findTextRandomByUserAndPositive($user))) {
                return $feedback->getText();
            }
        }
        return null;
    }

    /**
     * Get user feedback from cache
     * @param $answer
     * @return null
     */
    public function getAnswer($answer)
    {
        if (($question = $answer->getQuestion())) {
            if ($question->getType() == 'boolean') {
                return $answer->getValue() ? 'Ja' : 'Nein';
            }
        }

        if (($description = $answer->getDescription())) {
            return $description;
        }

        return null;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'fitbase_gamification_extension';
    }
} 