<?php

namespace Wellbeing\Bundle\ApiBundle\Imagick;


use Wellbeing\Bundle\ApiBundle\Entity\UserState;

class ProjectionBuilderXZ extends ProjectionBuilderAbstract
{
    protected $width;
    protected $height;
    protected $scaleX;
    protected $scaleY;

    protected $userState;

    protected $xMin;
    protected $zMin;
    protected $xMax;
    protected $zMax;

    public function __construct($width, $height, UserState $userState)
    {
        parent::__construct();

        $this->width = $width;
        $this->height = $height;
        $this->userState = $userState;

        $this->xMin = $userState->getMinXCoordinate();
        $this->zMin = $userState->getMinZCoordinate();

        $this->xMax = $userState->getMaxXCoordinate();
        $this->zMax = $userState->getMaxZCoordinate();


        if (($head = $userState->getHead())) {

            if (($shoulderC = $userState->getShoulderCenter())) {

                if (($spine = $userState->getSpine())) {

                    if (($hipL = $userState->getHipLeft())) {

                        if (($kneeL = $userState->getKneeLeft())) {

                            $this->setColor('grey');
                            $this->node($kneeL->getX(), $kneeL->getZ());
                            $this->edge($kneeL->getX(), $kneeL->getZ(), $hipL->getX(), $hipL->getZ());

                            if (($footL = $userState->getFootLeft())) {

                                $this->node($footL->getX(), $footL->getZ());
                                $this->edge($kneeL->getX(), $kneeL->getZ(), $footL->getX(), $footL->getZ());
                            }
                        }

                        $this->setColor('blue');
                        $this->node($hipL->getX(), $hipL->getZ());
                        $this->edge($spine->getX(), $spine->getZ(), $hipL->getX(), $hipL->getZ());
                    }

                    if (($hipR = $userState->getHipRight())) {

                        if (($kneeR = $userState->getKneeRight())) {

                            $this->setColor('grey');
                            $this->node($kneeR->getX(), $kneeR->getZ());
                            $this->edge($kneeR->getX(), $kneeR->getZ(), $hipR->getX(), $hipR->getZ());

                            if (($footR = $userState->getFootRight())) {

                                $this->node($footR->getX(), $footR->getZ());
                                $this->edge($kneeR->getX(), $kneeR->getZ(), $footR->getX(), $footR->getZ());
                            }
                        }

                        $this->setColor('blue');
                        $this->node($hipR->getX(), $hipR->getZ());
                        $this->edge($spine->getX(), $spine->getZ(), $hipR->getX(), $hipR->getZ());

                        if (($hipL = $userState->getHipLeft())) {
                            $this->edge($hipL->getX(), $hipL->getZ(), $hipR->getX(), $hipR->getZ());
                        }
                    }

                    $this->setColor('blue');
                    $this->node($spine->getX(), $spine->getZ());

                    if (($shoulderL = $userState->getShoulderLeft())) {
                        $this->edge($shoulderL->getX(), $shoulderL->getZ(), $spine->getX(), $spine->getZ());
                    }

                    if (($shoulderR = $userState->getShoulderRight())) {
                        $this->edge($shoulderR->getX(), $shoulderR->getZ(), $spine->getX(), $spine->getZ());
                    }
                }


                if (($shoulderR = $userState->getShoulderRight())) {

                    $this->setColor('green');
                    $this->edge($shoulderC->getX(), $shoulderC->getZ(), $shoulderR->getX(), $shoulderR->getZ());

                    $this->setColor('red');
                    $this->node($shoulderR->getX(), $shoulderR->getZ());

                    if (($elbowR = $userState->getElbowRight())) {

                        $this->node($elbowR->getX(), $elbowR->getZ());
                        $this->edge($shoulderR->getX(), $shoulderR->getZ(), $elbowR->getX(), $elbowR->getZ());

                        if (($handR = $userState->getHandRight())) {

                            $this->node($handR->getX(), $handR->getZ());
                            $this->edge($elbowR->getX(), $elbowR->getZ(), $handR->getX(), $handR->getZ());
                        }
                    }
                }

                if (($shoulderL = $userState->getShoulderLeft())) {

                    $this->setColor('green');
                    $this->edge($shoulderC->getX(), $shoulderC->getZ(), $shoulderL->getX(), $shoulderL->getZ());

                    $this->setColor('red');
                    $this->node($shoulderL->getX(), $shoulderL->getZ());

                    if (($elbowL = $userState->getElbowLeft())) {

                        $this->node($elbowL->getX(), $elbowL->getZ());
                        $this->edge($shoulderL->getX(), $shoulderL->getZ(), $elbowL->getX(), $elbowL->getZ());

                        if (($handL = $userState->getHandLeft())) {
                            $this->node($handL->getX(), $handL->getZ());
                            $this->edge($elbowL->getX(), $elbowL->getZ(), $handL->getX(), $handL->getZ());
                        }
                    }
                }

                $this->setColor('green');
                $this->edge($head->getX(), $head->getZ(), $shoulderC->getX(), $shoulderC->getZ());
                $this->node($shoulderC->getX(), $shoulderC->getZ());
            }

            $this->setColor('green');
            $this->nodeHead($head->getX(), $head->getZ());
        }
    }

    /**
     * @param $xRaw
     * @param $zRaw
     */
    protected function node($xRaw, $zRaw, $scale = 0.015)
    {
        $xMax = (($this->xMax - $this->xMin) * $this->width);
        $scaleX = $this->width / $xMax;

        $yMax = (($this->zMax - $this->zMin) * $this->height);
        $scaleY = $this->height / $yMax;

        $x = (($xRaw - $this->xMin) * $this->width * $scaleX);
        $y = (($zRaw - $this->zMin) * $this->height * $scaleY);

        $this->circle($x, $y, $x + ($this->width * $scale), $y);
    }

    /**
     * Draw a edge
     * @param $x1Raw
     * @param $z1Raw
     * @param $x2Raw
     * @param $z2Raw
     */
    protected function edge($x1Raw, $z1Raw, $x2Raw, $z2Raw)
    {
        $xMax = (($this->xMax - $this->xMin) * $this->width);
        $scaleX = $this->width / $xMax;

        $yMax = (($this->zMax - $this->zMin) * $this->height);
        $scaleY = $this->height / $yMax;

        $x1 = (($x1Raw - $this->xMin) * $this->width * $scaleX);
        $y1 = (($z1Raw - $this->zMin) * $this->height * $scaleY);

        $x2 = (($x2Raw - $this->xMin) * $this->width * $scaleX);
        $y2 = (($z2Raw - $this->zMin) * $this->height * $scaleY);

        $this->line($x1, $y1, $x2, $y2);
    }

}