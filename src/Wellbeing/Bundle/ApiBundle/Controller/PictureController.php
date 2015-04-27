<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 27/04/15
 * Time: 10:54
 */

namespace Wellbeing\Bundle\ApiBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PictureController extends Controller
{
    protected $xMax;
    protected $yMax;
    protected $width;
    protected $height;

    /**
     * Display company forest
     * @param Request $request
     * @return Response
     */
    public function stateAction(Request $request, $unique = null, $scale = 200)
    {
        $imagick = new \Imagick();
        $imagick->setBackgroundColor(new \ImagickPixel('transparent'));
        $imagick->readImageFile(fopen($this->get('kernel')->getRootDir() .
                '/Resources/views/' .
                'Wellbeing/UserState/background.jpg', 'r')
        );


        $imagick->scaleImage(350, 0);
        $imagick->setImageFormat("png");

        $this->width = $imagick->getImageWidth();
        $this->height = $imagick->getImageHeight();


        $entityManager = $this->get('entity_manager');
        $repositoryUserState = $entityManager->getRepository('Wellbeing\Bundle\ApiBundle\Entity\UserState');
        if (($userState = $repositoryUserState->find($unique))) {

            $draw = new \ImagickDraw();
            $draw->setFillColor('#000000');

            $xMin = $userState->getMinXCoordinate();

            $this->xMax = $this->getX($userState->getMaxXCoordinate(), $xMin, $scale);
            $this->yMax = $this->getY($userState->getMaxYCoordinate(), $xMin, $scale);

            $yMin = $userState->getMinYCoordinate();

            if (($head = $userState->getHead())) {

                $this->drawPoint($draw, $head->getX(), $head->getY(), $xMin, $yMin, $scale);

                if (($shoulderC = $userState->getShoulderCenter())) {

                    $this->drawPoint($draw, $shoulderC->getX(), $shoulderC->getY(), $xMin, $yMin, $scale);
                    $this->drawLine($draw, $head->getX(), $head->getY(), $shoulderC->getX(), $shoulderC->getY(), $xMin, $yMin, $scale);


                    if (($shoulderR = $userState->getShoulderRight())) {
                        $this->drawPoint($draw, $shoulderR->getX(), $shoulderR->getY(), $xMin, $yMin, $scale);
                        $this->drawLine($draw, $shoulderC->getX(), $shoulderC->getY(), $shoulderR->getX(), $shoulderR->getY(), $xMin, $yMin, $scale);

                        if (($elbowR = $userState->getElbowRight())) {

                            $this->drawPoint($draw, $elbowR->getX(), $elbowR->getY(), $xMin, $yMin, $scale);
                            $this->drawLine($draw, $shoulderR->getX(), $shoulderR->getY(), $elbowR->getX(), $elbowR->getY(), $xMin, $yMin, $scale);

                            if (($handR = $userState->getHandRight())) {

                                $this->drawPoint($draw, $handR->getX(), $handR->getY(), $xMin, $yMin, $scale);
                                $this->drawLine($draw, $elbowR->getX(), $elbowR->getY(), $handR->getX(), $handR->getY(), $xMin, $yMin, $scale);

                            }

                        }
                    }

                    if (($shoulderL = $userState->getShoulderLeft())) {

                        $this->drawPoint($draw, $shoulderL->getX(), $shoulderL->getY(), $xMin, $yMin, $scale);
                        $this->drawLine($draw, $shoulderC->getX(), $shoulderC->getY(), $shoulderL->getX(), $shoulderL->getY(), $xMin, $yMin, $scale);

                        if (($elbowL = $userState->getElbowLeft())) {

                            $this->drawPoint($draw, $elbowL->getX(), $elbowL->getY(), $xMin, $yMin, $scale);
                            $this->drawLine($draw, $shoulderL->getX(), $shoulderL->getY(), $elbowL->getX(), $elbowL->getY(), $xMin, $yMin, $scale);

                            if (($handL = $userState->getHandLeft())) {

                                $this->drawPoint($draw, $handL->getX(), $handL->getY(), $xMin, $yMin, $scale);
                                $this->drawLine($draw, $elbowL->getX(), $elbowL->getY(), $handL->getX(), $handL->getY(), $xMin, $yMin, $scale);
                            }
                        }

                    }

//                    if (($com = $userState->getCom())) {
//
//                        $this->drawPoint($draw, $com->getX(), $com->getY(), $xMin, $yMin, $scale);
//                        $this->drawLine($draw, $shoulderC->getX(), $shoulderC->getY(), $com->getX(), $com->getY(), $xMin, $yMin, $scale);
//
//                    }

                    if (($spine = $userState->getSpine())) {

                        $this->drawPoint($draw, $spine->getX(), $spine->getY(), $xMin, $yMin, $scale);
                        $this->drawLine($draw, $shoulderC->getX(), $shoulderC->getY(), $spine->getX(), $spine->getY(), $xMin, $yMin, $scale);


                        if (($hipL = $userState->getHipLeft())) {

                            $this->drawPoint($draw, $hipL->getX(), $hipL->getY(), $xMin, $yMin, $scale);
                            $this->drawLine($draw, $spine->getX(), $spine->getY(), $hipL->getX(), $hipL->getY(), $xMin, $yMin, $scale);


                            if (($kneeL = $userState->getKneeLeft())) {
                                $this->drawPoint($draw, $kneeL->getX(), $kneeL->getY(), $xMin, $yMin, $scale);
                                $this->drawLine($draw, $kneeL->getX(), $kneeL->getY(), $hipL->getX(), $hipL->getY(), $xMin, $yMin, $scale);

                                if (($footL = $userState->getFootLeft())) {

                                    $this->drawPoint($draw, $footL->getX(), $footL->getY(), $xMin, $yMin, $scale);
                                    $this->drawLine($draw, $kneeL->getX(), $kneeL->getY(), $footL->getX(), $footL->getY(), $xMin, $yMin, $scale);

                                }
                            }
                        }

                        if (($hipR = $userState->getHipRight())) {

                            $this->drawPoint($draw, $hipR->getX(), $hipR->getY(), $xMin, $yMin, $scale);
                            $this->drawLine($draw, $spine->getX(), $spine->getY(), $hipR->getX(), $hipR->getY(), $xMin, $yMin, $scale);

                            if (($kneeR = $userState->getKneeRight())) {
                                $this->drawPoint($draw, $kneeR->getX(), $kneeR->getY(), $xMin, $yMin, $scale);
                                $this->drawLine($draw, $kneeR->getX(), $kneeR->getY(), $hipR->getX(), $hipR->getY(), $xMin, $yMin, $scale);

                                if (($footR = $userState->getFootRight())) {
                                    $this->drawPoint($draw, $footR->getX(), $footR->getY(), $xMin, $yMin, $scale);
                                    $this->drawLine($draw, $kneeR->getX(), $kneeR->getY(), $footR->getX(), $footR->getY(), $xMin, $yMin, $scale);

                                }
                            }
                        }

                    }

                }
            }

            $imagick->drawImage($draw);
            $imagick->rotateImage(new \ImagickPixel(), 180);
        }
        return new Response($imagick, 200, array(
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'inline; filename="state.png"'
        ));
    }

    /**
     * Draw a point
     * @param $draw
     * @param $xRaw
     * @param $yRaw
     * @param $xMin
     * @param $yMin
     * @param $scale
     */
    protected function drawPoint(&$draw, $xRaw, $yRaw, $xMin, $yMin, $scale)
    {

        $x = $this->getX($xRaw, $xMin, $scale);
        $y = $this->getY($yRaw, $yMin, $scale);


        $x += ($this->width - $this->xMax) / 2;

        $draw->circle($x, $y, $x + ($scale * 0.015), $y);

    }

    /**
     * Draw a line
     * @param $draw
     * @param $x1Raw
     * @param $y1Raw
     * @param $x2Raw
     * @param $y2Raw
     * @param $xMin
     * @param $yMin
     * @param $scale
     */
    protected function drawLine(&$draw, $x1Raw, $y1Raw, $x2Raw, $y2Raw, $xMin, $yMin, $scale)
    {
        $x1 = $this->getX($x1Raw, $xMin, $scale);
        $y1 = $this->getY($y1Raw, $yMin, $scale);

        $x2 = $this->getX($x2Raw, $xMin, $scale);
        $y2 = $this->getY($y2Raw, $yMin, $scale);

        $x1 += ($this->width - $this->xMax) / 2;
        $x2 += ($this->width - $this->xMax) / 2;

        $draw->line($x1, $y1, $x2, $y2);
    }

    /**
     * Get x
     * @param $xRaw
     * @param $xMin
     * @param $scale
     * @return mixed
     */
    protected function getX($xRaw, $xMin, $scale)
    {
        return (($xRaw - $xMin) * $scale);
    }

    /**
     * Get y
     * @param $yRaw
     * @param $yMin
     * @param $scale
     * @return mixed
     */
    protected function getY($yRaw, $yMin, $scale)
    {
        return (($yRaw - $yMin) * $scale);
    }
}