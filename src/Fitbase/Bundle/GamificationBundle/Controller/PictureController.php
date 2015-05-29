<?php

namespace Fitbase\Bundle\GamificationBundle\Controller;

use Fitbase\Bundle\GamificationBundle\Form\GamificationUserDialogAnswerForm;
use Graph;
use JpGraph\JpGraph;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UniversalTheme;

class PictureController extends Controller
{
    /**
     * Display user chat with avatar
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function avatarAction(Request $request)
    {
        $imagick = new \Imagick();
        $imagick->setBackgroundColor(new \ImagickPixel('transparent'));
        $imagick->readImageBlob($this->renderView('Gamification/Picture/Avatar.html.twig', array()));
        $imagick->scaleImage(800, 0);


        if (($gamification = $this->get('gamification')->current())) {

            $date = $this->get('datetime')->getDateTime('now');

            if (($media = $gamification->getAvatarMedia($date))) {

                $root = $this->get('kernel')->getRootDir() . '/../web';
                $path = $this->container->get('sonata.media.twig.extension')->path($media, 'preview');

                $imagick2 = new \Imagick();
                $imagick2->readImageBlob(\file_get_contents($root . $path));
                $imagick2->adaptiveResizeImage(250, 250);

                $imagick->setImageVirtualPixelMethod(\Imagick::VIRTUALPIXELMETHOD_TRANSPARENT);

                $imagick->compositeImage($imagick2, \Imagick::COMPOSITE_DEFAULT, 440, 155);
            }
        }


        if (($company = $this->get('company')->current())) {
            if (($gamification = $company->getGamification())) {

                $date = $this->get('datetime')->getDateTime('now');
                $points = $this->get('statistic')->points($this->get('user')->current());

                if (($media = $gamification->getTreeMedia($date, $points))) {

                    $root = $this->get('kernel')->getRootDir() . '/../web';
                    $path = $this->container->get('sonata.media.twig.extension')->path($media, 'preview');

                    $imagick2 = new \Imagick();
                    $imagick2->readImageBlob(\file_get_contents($root . $path));
                    $imagick2->adaptiveResizeImage(380, 380);

                    $imagick->setImageVirtualPixelMethod(\Imagick::VIRTUALPIXELMETHOD_TRANSPARENT);
                    $imagick->compositeImage($imagick2, \Imagick::COMPOSITE_DEFAULT, 30, 28);
                }
            }
        }

        $result = $imagick->mergeImageLayers(\Imagick::LAYERMETHOD_MERGE);
        $result->setImageFormat("png");

        return new Response($result->getImageBlob(), 200, array(
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'inline; filename="avatar.png"'
        ));
    }


    /**
     * Display company forest
     * @param Request $request
     * @return Response
     */
    public function forestAction(Request $request)
    {
        $imagick = new \Imagick();
        $imagick->setBackgroundColor(new \ImagickPixel('transparent'));
        $imagick->readImageBlob($this->renderView('Gamification/Picture/Forest.html.twig', array()));
        $imagick->adaptiveResizeImage(718, 718);

        $imagick->setImageFormat("png");

        return new Response($imagick, 200, array(
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'inline; filename="forest.png"'
        ));
    }

    /**
     * Display user statistic graph
     * @param Request $request
     * @return Response
     */
    public function statisticAction(Request $request)
    {
        $imagick = new \Imagick();
        $imagick->setBackgroundColor(new \ImagickPixel('transparent'));
        $imagick->readImageBlob($this->renderView('Gamification/Picture/Avatar.html.twig', array()));

        if (($user = $this->container->get('user')->current())) {
            if (($statistics = $this->container->get('statistic')->statistic($user))) {

                $datetime = $this->container->get('datetime');

                if (empty($statistics)) {
                    $statistics = array(array(
                        'date' => $datetime->getDateTime('now'),
                        'count_point_total' => 0,
                    ));
                }

                $cache = array();
                foreach ($statistics as $statistic) {
                    if (($data = isset($statistic['date']) ? $statistic['date'] : null)) {

                        $index = (int)"{$data->format('Y')}{$data->format('m')}";

                        if (!isset($cache[$index])) {
                            $cache[$index] = array(
                                "date" => $data->setTime(0, 0, 0),
                                "points" => 0,
                            );
                        }

                        $cache[$index]['points'] += $statistic['count_point_total'];
                    }
                }

            } else {
              $cache = [];
              $cache[0] = array(
                "date" => (new \DateTime('now'))->setTime(0, 0, 0),
                "points" => 0,
              );
            }

                ksort($cache);

                $summ = 0;
                $labels = array();
                $values = array();

                $translator = $this->container->get('translator');
                foreach ($cache as $cacheEntity) {
                    if (($data = isset($cacheEntity['date']) ? $cacheEntity['date'] : null) !== null) {
                        if (($summ += isset($cacheEntity['points']) ? $cacheEntity['points'] : null) !== null) {
                            array_push($values, $summ);

                            $label = $translator->trans(strtolower($data->format("F")), array(), 'FitbaseGamificationBundle');
                            array_push($labels, $label);
                        }
                    }
                }

                JpGraph::load();
                JpGraph::module('line');
                JpGraph::module('bar');


                $graph = new Graph(660, 654, 'auto');
                $graph->SetScale("textlin");

                $graph->SetTheme(new UniversalTheme);
                $graph->SetMargin(70, 0, 20, 50);
                $graph->img->SetAngle(0);

                $graph->SetBox(false);

                $graph->ygrid->Show(false);
                $graph->ygrid->SetFill(false);

                $graph->xaxis->SetFont(FF_VERDANA, FS_NORMAL, 20);
                $graph->xaxis->SetTickLabels($labels);



                $graph->yaxis->SetFont(FF_VERDANA, FS_NORMAL, 20);
                $graph->yaxis->HideLine(false);
                $graph->yaxis->HideTicks(false, false);

                $graph->SetBackgroundGradient('#FFFFFF', '#FFFFFF', GRAD_HOR, BGRAD_PLOT);

                $b1plot = new \BarPlot($values);
                $b1plot->SetFillGradient("#c0e3e8", "#c0e3e8", GRAD_HOR);
                $b1plot->SetWidth(120);
                $b1plot->SetWeight(0);
                $graph->Add($b1plot);
                $graph->Stroke(_IMG_HANDLER);

                //Start buffering
                ob_start();
                $graph->img->Stream();
                $image = ob_get_contents();
                ob_end_clean();

                $imagick->readImageBlob($image);
        }

        $imagick->adaptiveResizeImage(718, 718);
        $imagick->setImageFormat("png");

        return new Response($imagick, 200, array(
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'inline; filename="forest.png"'
        ));
    }
}
