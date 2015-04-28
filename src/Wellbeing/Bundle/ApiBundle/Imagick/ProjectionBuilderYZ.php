<?php

namespace Wellbeing\Bundle\ApiBundle\Imagick;


use Wellbeing\Bundle\ApiBundle\Entity\UserState;

class ProjectionBuilderYZ extends ProjectionBuilderAbstract
{
    protected $width;
    protected $height;
    protected $userState;

    protected $yMin;
    protected $zMin;
    protected $yMax;
    protected $zMax;

    public function __construct($width, $height, UserState $userState)
    {
        parent::__construct();

        $this->width = $width;
        $this->height = $height;
        $this->userState = $userState;

        $this->yMin = $userState->getMinYCoordinate();
        $this->zMin = $userState->getMinZCoordinate();

        $this->yMax = $userState->getMaxYCoordinate();
        $this->zMax = $userState->getMaxZCoordinate();


        if (($head = $userState->getHead())) {

            if (($shoulderC = $userState->getShoulderCenter())) {

                if (($spine = $userState->getSpine())) {

                    if (($hipL = $userState->getHipLeft())) {

                        if (($kneeL = $userState->getKneeLeft())) {

                            $this->setColor('grey');
                            $this->node($kneeL->getY(), $kneeL->getZ());
                            $this->edge($kneeL->getY(), $kneeL->getZ(), $hipL->getY(), $hipL->getZ());

                            if (($footL = $userState->getFootLeft())) {

                                $this->node($footL->getY(), $footL->getZ());
                                $this->edge($kneeL->getY(), $kneeL->getZ(), $footL->getY(), $footL->getZ());
                            }
                        }

                        $this->setColor('blue');
                        $this->node($hipL->getY(), $hipL->getZ());
                        $this->edge($spine->getY(), $spine->getZ(), $hipL->getY(), $hipL->getZ());
                    }

                    if (($hipR = $userState->getHipRight())) {

                        if (($kneeR = $userState->getKneeRight())) {

                            $this->setColor('grey');
                            $this->node($kneeR->getY(), $kneeR->getZ());
                            $this->edge($kneeR->getY(), $kneeR->getZ(), $hipR->getY(), $hipR->getZ());

                            if (($footR = $userState->getFootRight())) {

                                $this->node($footR->getY(), $footR->getZ());
                                $this->edge($kneeR->getY(), $kneeR->getZ(), $footR->getY(), $footR->getZ());
                            }
                        }

                        $this->setColor('blue');
                        $this->node($hipR->getY(), $hipR->getZ());
                        $this->edge($spine->getY(), $spine->getZ(), $hipR->getY(), $hipR->getZ());

                        if (($hipL = $userState->getHipLeft())) {
                            $this->edge($hipL->getY(), $hipL->getZ(), $hipR->getY(), $hipR->getZ());
                        }
                    }

                    $this->setColor('blue');
                    $this->node($spine->getY(), $spine->getZ());

                    if (($shoulderL = $userState->getShoulderLeft())) {
                        $this->edge($shoulderL->getY(), $shoulderL->getZ(), $spine->getY(), $spine->getZ());
                    }

                    if (($shoulderR = $userState->getShoulderRight())) {
                        $this->edge($shoulderR->getY(), $shoulderR->getZ(), $spine->getY(), $spine->getZ());
                    }
                }


                if (($shoulderR = $userState->getShoulderRight())) {

                    $this->setColor('green');
                    $this->edge($shoulderC->getY(), $shoulderC->getZ(), $shoulderR->getY(), $shoulderR->getZ());

                    $this->setColor('red');
                    $this->node($shoulderR->getY(), $shoulderR->getZ());

                    if (($elbowR = $userState->getElbowRight())) {

                        $this->node($elbowR->getY(), $elbowR->getZ());
                        $this->edge($shoulderR->getY(), $shoulderR->getZ(), $elbowR->getY(), $elbowR->getZ());

                        if (($handR = $userState->getHandRight())) {

                            $this->node($handR->getY(), $handR->getZ());
                            $this->edge($elbowR->getY(), $elbowR->getZ(), $handR->getY(), $handR->getZ());
                        }

                    }
                }

                if (($shoulderL = $userState->getShoulderLeft())) {

                    $this->setColor('green');
                    $this->edge($shoulderC->getY(), $shoulderC->getZ(), $shoulderL->getY(), $shoulderL->getZ());

                    $this->setColor('red');
                    $this->node($shoulderL->getY(), $shoulderL->getZ());

                    if (($elbowL = $userState->getElbowLeft())) {

                        $this->node($elbowL->getY(), $elbowL->getZ());
                        $this->edge($shoulderL->getY(), $shoulderL->getZ(), $elbowL->getY(), $elbowL->getZ());

                        if (($handL = $userState->getHandLeft())) {
                            $this->node($handL->getY(), $handL->getZ());
                            $this->edge($elbowL->getY(), $elbowL->getZ(), $handL->getY(), $handL->getZ());
                        }
                    }
                }

                $this->setColor('green');
                $this->node($shoulderC->getY(), $shoulderC->getZ());
                $this->edge($head->getY(), $head->getZ(), $shoulderC->getY(), $shoulderC->getZ());
            }

            $this->setColor('green');
            $this->nodeHead($head->getY(), $head->getZ());
        }
    }

    /**
     * @param $yRaw
     * @param $zRaw
     */
    protected function node($yRaw, $zRaw, $scale = 0.015)
    {
        $xMax = (($this->yMax - $this->yMin) * $this->width);
        $scaleX = $this->width / $xMax;

        $yMax = (($this->zMax - $this->zMin) * $this->height);
        $scaleY = $this->height / $yMax;

        $x = (($yRaw - $this->yMin) * $this->width * $scaleX);
        $y = (($zRaw - $this->zMin) * $this->height * $scaleY);

        $this->circle($x, $y, $x + ($this->width * $scale), $y);
    }

    /**
     * Draw a edge
     * @param $y1Raw
     * @param $z1Raw
     * @param $y2Raw
     * @param $z2Raw
     */
    protected function edge($y1Raw, $z1Raw, $y2Raw, $z2Raw)
    {
        $xMax = (($this->yMax - $this->yMin) * $this->width);
        $scaleX = $this->width / $xMax;

        $yMax = (($this->zMax - $this->zMin) * $this->height);
        $scaleY = $this->height / $yMax;


        $x1 = (($y1Raw - $this->yMin) * $this->width * $scaleX);
        $y1 = (($z1Raw - $this->zMin) * $this->height * $scaleY);

        $x2 = (($y2Raw - $this->yMin) * $this->width * $scaleX);
        $y2 = (($z2Raw - $this->zMin) * $this->height * $scaleY);

        $this->line($x1, $y1, $x2, $y2);
    }

}