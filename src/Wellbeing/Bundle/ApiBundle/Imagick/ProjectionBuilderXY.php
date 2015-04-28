<?php

namespace Wellbeing\Bundle\ApiBundle\Imagick;


use Wellbeing\Bundle\ApiBundle\Entity\UserState;

class ProjectionBuilderXY extends ProjectionBuilderAbstract
{
    protected $width;
    protected $height;
    protected $userState;

    protected $xMin;
    protected $yMin;
    protected $xMax;
    protected $yMax;

    public function __construct($width, $height, UserState $userState)
    {
        parent::__construct();

        $this->width = $width;
        $this->height = $height;
        $this->userState = $userState;

        $this->xMin = $userState->getMinXCoordinate();
        $this->yMin = $userState->getMinYCoordinate();

        $this->xMax = $userState->getMaxXCoordinate();
        $this->yMax = $userState->getMaxYCoordinate();


        if (($head = $userState->getHead())) {

            $this->setColor('green');
            $this->nodeHead($head->getX(), $head->getY());

            if (($shoulderC = $userState->getShoulderCenter())) {

                $this->setColor('green');
                $this->node($shoulderC->getX(), $shoulderC->getY());
                $this->edge($head->getX(), $head->getY(), $shoulderC->getX(), $shoulderC->getY());

                if (($spine = $userState->getSpine())) {

                    $this->setColor('blue');
                    $this->node($spine->getX(), $spine->getY());

                    if (($shoulderL = $userState->getShoulderLeft())) {
                        $this->edge($shoulderL->getX(), $shoulderL->getY(), $spine->getX(), $spine->getY());
                    }

                    if (($shoulderR = $userState->getShoulderRight())) {
                        $this->edge($shoulderR->getX(), $shoulderR->getY(), $spine->getX(), $spine->getY());
                    }

                    if (($hipL = $userState->getHipLeft())) {

                        if (($kneeL = $userState->getKneeLeft())) {

                            $this->setColor('grey');
                            $this->node($kneeL->getX(), $kneeL->getY());
                            $this->edge($kneeL->getX(), $kneeL->getY(), $hipL->getX(), $hipL->getY());

                            if (($footL = $userState->getFootLeft())) {

                                $this->node($footL->getX(), $footL->getY());
                                $this->edge($kneeL->getX(), $kneeL->getY(), $footL->getX(), $footL->getY());
                            }
                        }

                        $this->setColor('blue');
                        $this->node($hipL->getX(), $hipL->getY());
                        $this->edge($spine->getX(), $spine->getY(), $hipL->getX(), $hipL->getY());
                    }

                    if (($hipR = $userState->getHipRight())) {

                        if (($kneeR = $userState->getKneeRight())) {

                            $this->setColor('grey');
                            $this->node($kneeR->getX(), $kneeR->getY());
                            $this->edge($kneeR->getX(), $kneeR->getY(), $hipR->getX(), $hipR->getY());

                            if (($footR = $userState->getFootRight())) {

                                $this->node($footR->getX(), $footR->getY());
                                $this->edge($kneeR->getX(), $kneeR->getY(), $footR->getX(), $footR->getY());
                            }
                        }

                        $this->setColor('blue');
                        if (($hipL = $userState->getHipLeft())) {
                            $this->edge($hipL->getX(), $hipL->getY(), $hipR->getX(), $hipR->getY());
                        }

                        $this->node($hipR->getX(), $hipR->getY());
                        $this->edge($spine->getX(), $spine->getY(), $hipR->getX(), $hipR->getY());

                    }


                    if (($shoulderR = $userState->getShoulderRight())) {

                        if (($elbowR = $userState->getElbowRight())) {

                            $this->setColor('red');
                            $this->node($elbowR->getX(), $elbowR->getY());
                            $this->edge($shoulderR->getX(), $shoulderR->getY(), $elbowR->getX(), $elbowR->getY());

                            if (($handR = $userState->getHandRight())) {

                                $this->node($handR->getX(), $handR->getY());
                                $this->edge($elbowR->getX(), $elbowR->getY(), $handR->getX(), $handR->getY());
                            }
                        }

                        $this->setColor('green');
                        $this->edge($shoulderC->getX(), $shoulderC->getY(), $shoulderR->getX(), $shoulderR->getY());

                        $this->setColor('red');
                        $this->node($shoulderR->getX(), $shoulderR->getY());

                    }

                    if (($shoulderL = $userState->getShoulderLeft())) {

                        $this->setColor('green');
                        $this->edge($shoulderC->getX(), $shoulderC->getY(), $shoulderL->getX(), $shoulderL->getY());

                        $this->setColor('red');
                        $this->node($shoulderL->getX(), $shoulderL->getY());

                        if (($elbowL = $userState->getElbowLeft())) {

                            $this->node($elbowL->getX(), $elbowL->getY());
                            $this->edge($shoulderL->getX(), $shoulderL->getY(), $elbowL->getX(), $elbowL->getY());

                            if (($handL = $userState->getHandLeft())) {

                                $this->node($handL->getX(), $handL->getY());
                                $this->edge($elbowL->getX(), $elbowL->getY(), $handL->getX(), $handL->getY());
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * @param $xRaw
     * @param $yRaw
     * @param float $scale
     */
    protected function node($xRaw, $yRaw, $scale = 0.015)
    {
        $xMax = (($this->xMax - $this->xMin) * $this->width);
        $scaleX = $this->width / $xMax;

        $yMax = (($this->yMax - $this->yMin) * $this->height);
        $scaleY = $this->height / $yMax;

        $x = (($xRaw - $this->xMin) * $this->width * $scaleX);
        $y = (($yRaw - $this->yMin) * $this->height * $scaleY);

        $this->circle($x, $y, $x + ($this->width * $scale), $y);
    }

    /**
     * Draw a edge
     * @param $x1Raw
     * @param $y1Raw
     * @param $x2Raw
     * @param $y2Raw
     */
    protected function edge($x1Raw, $y1Raw, $x2Raw, $y2Raw)
    {
        $xMax = (($this->xMax - $this->xMin) * $this->width);
        $scaleX = $this->width / $xMax;

        $yMax = (($this->yMax - $this->yMin) * $this->height);
        $scaleY = $this->height / $yMax;

        $x1 = (($x1Raw - $this->xMin) * $this->width * $scaleX);
        $y1 = (($y1Raw - $this->yMin) * $this->height * $scaleY);

        $x2 = (($x2Raw - $this->xMin) * $this->width * $scaleX);
        $y2 = (($y2Raw - $this->yMin) * $this->height * $scaleY);

        $this->line($x1, $y1, $x2, $y2);
    }

}