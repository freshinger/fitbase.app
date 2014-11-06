<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/12/14
 * Time: 12:40 PM
 */

namespace Fitbase\Bundle\GamificationBundle\Helper;


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
            new \Twig_SimpleFunction('color', array($this, 'getTreeColor')),
            new \Twig_SimpleFunction('emotion', array($this, 'getEmotion')),
            new \Twig_SimpleFunction('image', array($this, 'image')),
            new \Twig_SimpleFunction('graph', array($this, 'graph')),
        );
    }


    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('feedback', array($this, 'getUserFeedbackCache')),
            new \Twig_SimpleFilter('tree', array($this, 'getUserTree')),
            new \Twig_SimpleFilter('forest', array($this, 'getCompanyForest')),
            new \Twig_SimpleFilter('forestPercent', array($this, 'getCompanyPercent')),
            new \Twig_SimpleFilter('emotion', array($this, 'getEmotion')),
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


        $graph = new Graph(285, 325, 'auto');
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
        $graph->yaxis->SetTickLabels(array(0, 1, 10, 20, 100, 200, 500, 1000, 10000));

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

        return '<img src="data:image/png;base64,' . base64_encode($image) . '"  />';
    }

    /**
     * Convert svg image to png
     * @param $content
     * @param int $width
     * @return null|string
     */
    public function image($content, $width = 275)
    {
        if (!strlen($content)) {
            return null;
        }

        $imagick = new \Imagick();
        $imagick->setBackgroundColor(new \ImagickPixel('transparent'));
        $imagick->readImageBlob('<?xml version="1.0" encoding="UTF-8" standalone="no"?>' . $content);
        $imagick->scaleImage($width, 0);
        $imagick->setImageFormat("png");

        return '<img src="data:image/png;base64,' . base64_encode($imagick) . '"  />';
    }

    /**
     * Try to get emotion short-code
     * @param $int
     * @return null
     */
    public function getEmotion($int)
    {
        $association = array(
            -2 => 'anger',
            -1 => 'sad',
            0 => 'normal',
            1 => 'gut',
            2 => 'happy'
        );

        if (isset($association[$int])) {
            return $association[$int];
        }

        return null;
    }

    /**
     * Get user feedback from cache
     * @param $answer
     * @return null
     */
    public function getUserFeedbackCache($answer)
    {
        if (($unique = $answer->getId())) {
            $cache = $this->container->get('gamification_cache');
            if ($cache->has($unique)) {
                return $cache->get($unique);
            } else {
                if (($question = $answer->getQuestion())) {
                    if ($question->getType() == 'boolean') {
                        return $answer->getValue() ? 'Ja' : 'Nein';
                    }
                }
            }
        }
        return null;
    }

    /**
     * Calculate a color
     * @param $percent
     * @param $color1
     * @param $color2
     * @return mixed
     */
    public function getTreeColor($percent, $color1, $color2)
    {
        return (rand(1, 80) < (100 - $percent)) ? $color1 : $color2;
    }

    /**
     * Return user tree
     * @param $user
     * @return null
     */
    public function getUserTree($user)
    {
        $managerEntity = $this->container->get('fitbase_entity_manager');
        $repositoryGamificationUserPointlog = $managerEntity->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUserPointlog');
        if (($GamificationUserPointlog = $repositoryGamificationUserPointlog->findOneLastByUser($user))) {
            return $GamificationUserPointlog->getImage();
        }
        return $this->container->get('gamification')->tree(1300);
    }

    /**
     * Display company percent
     * @param null $company
     * @return float|int
     */
    public function getCompanyPercent($company = null)
    {
        if (!empty($company)) {

            $managerEntity = $this->container->get('fitbase_entity_manager');
            $repositoryUserMeta = $managerEntity->getRepository('Ekino\WordpressBundle\Entity\UserMeta');
            $repositoryGamificationUserPointlog = $managerEntity->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUserPointlog');

            $collectionUserMeta = $repositoryUserMeta->findBy(array(
                'key' => 'user_company_id',
                'value' => $company->getId(),
            ));

            if (!empty($collectionUserMeta)) {

                $collectionUser = array();
                foreach ($collectionUserMeta as $userMeta) {
                    array_push($collectionUser, $userMeta->getUser());
                }


                $countPointlog = 0;
                $countPointlogPoint = 0;
                $collectionGamificationUserPointlog = $repositoryGamificationUserPointlog->findAllByUserIdArray($collectionUser);
                foreach ($collectionGamificationUserPointlog as $pointlog) {
                    $countPointlog += 1;
                    $countPointlogPoint += $pointlog->getCountPointTotal();
                }
                return $countPointlogPoint / $countPointlog;
            }
        }

        return 0;
    }

    /**
     * @param $company
     * @return mixed
     */
    public function getCompanyForest($company)
    {
        if (!$company instanceof \Fitbase\Bundle\CompanyBundle\Entity\Company) {
            return $this->container->get('gamification')->forest(2600);
        }

        $managerEntity = $this->container->get('fitbase_entity_manager');
        $repositoryUserMeta = $managerEntity->getRepository('Ekino\WordpressBundle\Entity\UserMeta');
        $repositoryGamificationUserPointlog = $managerEntity->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUserPointlog');

        $collectionUserMeta = $repositoryUserMeta->findBy(array(
            'key' => 'user_company_id',
            'value' => $company->getId(),
        ));

        $collectionUser = array();
        foreach ($collectionUserMeta as $userMeta) {
            array_push($collectionUser, $userMeta->getUser());
        }

        $countPointlog = 0;
        $countPointlogPoint = 0;
        $collectionGamificationUserPointlog = $repositoryGamificationUserPointlog->findAllByUserIdArray($collectionUser);
        foreach ($collectionGamificationUserPointlog as $pointlog) {
            $countPointlog += 1;
            $countPointlogPoint += $pointlog->getCountPointTotal();
        }

        return $this->container->get('gamification')->forest($countPointlogPoint / $countPointlog);
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