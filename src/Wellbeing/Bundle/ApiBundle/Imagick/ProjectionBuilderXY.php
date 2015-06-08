<?php

namespace Wellbeing\Bundle\ApiBundle\Imagick;


class ProjectionBuilderXY extends ProjectionBuilderAbstract implements ProjectionBuilderInterface
{
    /**
     * Build an image
     * @return $this|void
     */
    public function build()
    {
        parent::build();

        if (($head = $this->userState->getHead())) {

            $this->setColor($this->getColor('head'));
            $this->nodeHead($head->getX(), $head->getY());

            if (($shoulderC = $this->userState->getShoulderCenter())) {

                $this->setColor($this->getColor('head'));
                $this->node($shoulderC->getX(), $shoulderC->getY());
                $this->edge($head->getX(), $head->getY(), $shoulderC->getX(), $shoulderC->getY());

                if (($spine = $this->userState->getSpine())) {

                    $this->setColor($this->getColor('spine'));
                    $this->node($spine->getX(), $spine->getY());

                    if (($shoulderL = $this->userState->getShoulderLeft())) {
                        $this->edge($shoulderL->getX(), $shoulderL->getY(), $spine->getX(), $spine->getY());
                    }

                    if (($shoulderR = $this->userState->getShoulderRight())) {
                        $this->edge($shoulderR->getX(), $shoulderR->getY(), $spine->getX(), $spine->getY());
                    }

                    if (($hipL = $this->userState->getHipLeft())) {

                        if (($kneeL = $this->userState->getKneeLeft())) {

                            $this->setColor($this->getColor('knee'));
//                            $this->node($kneeL->getX(), $kneeL->getY());
//                            $this->edge($kneeL->getX(), $kneeL->getY(), $hipL->getX(), $hipL->getY());

                            if (($footL = $this->userState->getFootLeft())) {

//                                $this->node($footL->getX(), $footL->getY());
//                                $this->edge($kneeL->getX(), $kneeL->getY(), $footL->getX(), $footL->getY());
                            }
                        }

                        $this->setColor($this->getColor('hip'));
                        $this->node($hipL->getX(), $hipL->getY());
                        $this->edge($spine->getX(), $spine->getY(), $hipL->getX(), $hipL->getY());
                    }

                    if (($hipR = $this->userState->getHipRight())) {

                        if (($kneeR = $this->userState->getKneeRight())) {

                            $this->setColor($this->getColor('knee'));
//                            $this->node($kneeR->getX(), $kneeR->getY());
//                            $this->edge($kneeR->getX(), $kneeR->getY(), $hipR->getX(), $hipR->getY());

                            if (($footR = $this->userState->getFootRight())) {

//                                $this->node($footR->getX(), $footR->getY());
//                                $this->edge($kneeR->getX(), $kneeR->getY(), $footR->getX(), $footR->getY());
                            }
                        }

                        $this->setColor($this->getColor('hip'));
                        if (($hipL = $this->userState->getHipLeft())) {
                            $this->edge($hipL->getX(), $hipL->getY(), $hipR->getX(), $hipR->getY());
                        }

                        $this->node($hipR->getX(), $hipR->getY());
                        $this->edge($spine->getX(), $spine->getY(), $hipR->getX(), $hipR->getY());

                    }


                    if (($shoulderR = $this->userState->getShoulderRight())) {

                        if (($elbowR = $this->userState->getElbowRight())) {

                            $this->setColor($this->getColor('shoulder'));
                            $this->node($elbowR->getX(), $elbowR->getY());
                            $this->edge($shoulderR->getX(), $shoulderR->getY(), $elbowR->getX(), $elbowR->getY());

                            if (($handR = $this->userState->getHandRight())) {

                                $this->node($handR->getX(), $handR->getY());
                                $this->edge($elbowR->getX(), $elbowR->getY(), $handR->getX(), $handR->getY());
                            }
                        }

                        $this->setColor($this->getColor('edge'));
                        $this->edge($shoulderC->getX(), $shoulderC->getY(), $shoulderR->getX(), $shoulderR->getY());

                        $this->setColor($this->getColor('shoulder'));
                        $this->node($shoulderR->getX(), $shoulderR->getY());

                    }

                    if (($shoulderL = $this->userState->getShoulderLeft())) {

                        $this->setColor($this->getColor('edge'));
                        $this->edge($shoulderC->getX(), $shoulderC->getY(), $shoulderL->getX(), $shoulderL->getY());

                        $this->setColor($this->getColor('shoulder'));
                        $this->node($shoulderL->getX(), $shoulderL->getY());

                        if (($elbowL = $this->userState->getElbowLeft())) {

                            $this->node($elbowL->getX(), $elbowL->getY());
                            $this->edge($shoulderL->getX(), $shoulderL->getY(), $elbowL->getX(), $elbowL->getY());

                            if (($handL = $this->userState->getHandLeft())) {

                                $this->node($handL->getX(), $handL->getY());
                                $this->edge($elbowL->getX(), $elbowL->getY(), $handL->getX(), $handL->getY());
                            }
                        }
                    }
                }
            }
        }

        return $this;
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