<?php

namespace Wellbeing\Bundle\ApiBundle\Imagick;


class ProjectionBuilderYZ extends ProjectionBuilderAbstract implements ProjectionBuilderInterface
{
    public function build()
    {
        parent::build();

        if (($head = $this->userState->getHead())) {

            if (($shoulderC = $this->userState->getShoulderCenter())) {

                if (($spine = $this->userState->getSpine())) {

                    if (($hipL = $this->userState->getHipLeft())) {

                        if (($kneeL = $this->userState->getKneeLeft())) {

                            $this->setColor($this->getColor('knee'));
//                            $this->node($kneeL->getY(), $kneeL->getZ());
//                            $this->edge($kneeL->getY(), $kneeL->getZ(), $hipL->getY(), $hipL->getZ());

                            if (($footL = $this->userState->getFootLeft())) {

//                                $this->node($footL->getY(), $footL->getZ());
//                                $this->edge($kneeL->getY(), $kneeL->getZ(), $footL->getY(), $footL->getZ());
                            }
                        }

                        $this->setColor($this->getColor('hip'));
                        $this->node($hipL->getY(), $hipL->getZ());
                        $this->edge($spine->getY(), $spine->getZ(), $hipL->getY(), $hipL->getZ());
                    }

                    if (($hipR = $this->userState->getHipRight())) {

                        if (($kneeR = $this->userState->getKneeRight())) {

                            $this->setColor($this->getColor('knee'));
//                            $this->node($kneeR->getY(), $kneeR->getZ());
//                            $this->edge($kneeR->getY(), $kneeR->getZ(), $hipR->getY(), $hipR->getZ());

                            if (($footR = $this->userState->getFootRight())) {

//                                $this->node($footR->getY(), $footR->getZ());
//                                $this->edge($kneeR->getY(), $kneeR->getZ(), $footR->getY(), $footR->getZ());
                            }
                        }

                        $this->setColor($this->getColor('hip'));
                        $this->node($hipR->getY(), $hipR->getZ());
                        $this->edge($spine->getY(), $spine->getZ(), $hipR->getY(), $hipR->getZ());

                        if (($hipL = $this->userState->getHipLeft())) {
                            $this->edge($hipL->getY(), $hipL->getZ(), $hipR->getY(), $hipR->getZ());
                        }
                    }

                    $this->setColor($this->getColor('spine'));
                    $this->node($spine->getY(), $spine->getZ());

                    if (($shoulderL = $this->userState->getShoulderLeft())) {
                        $this->edge($shoulderL->getY(), $shoulderL->getZ(), $spine->getY(), $spine->getZ());
                    }

                    if (($shoulderR = $this->userState->getShoulderRight())) {
                        $this->edge($shoulderR->getY(), $shoulderR->getZ(), $spine->getY(), $spine->getZ());
                    }
                }


                if (($shoulderR = $this->userState->getShoulderRight())) {

                    $this->setColor($this->getColor('edge'));
                    $this->edge($shoulderC->getY(), $shoulderC->getZ(), $shoulderR->getY(), $shoulderR->getZ());

                    $this->setColor($this->getColor('shoulder'));
                    $this->node($shoulderR->getY(), $shoulderR->getZ());

                    if (($elbowR = $this->userState->getElbowRight())) {

                        $this->node($elbowR->getY(), $elbowR->getZ());
                        $this->edge($shoulderR->getY(), $shoulderR->getZ(), $elbowR->getY(), $elbowR->getZ());

                        if (($handR = $this->userState->getHandRight())) {

                            $this->node($handR->getY(), $handR->getZ());
                            $this->edge($elbowR->getY(), $elbowR->getZ(), $handR->getY(), $handR->getZ());
                        }

                    }
                }

                if (($shoulderL = $this->userState->getShoulderLeft())) {

                    $this->setColor($this->getColor('edge'));
                    $this->edge($shoulderC->getY(), $shoulderC->getZ(), $shoulderL->getY(), $shoulderL->getZ());

                    $this->setColor($this->getColor('shoulder'));
                    $this->node($shoulderL->getY(), $shoulderL->getZ());

                    if (($elbowL = $this->userState->getElbowLeft())) {

                        $this->node($elbowL->getY(), $elbowL->getZ());
                        $this->edge($shoulderL->getY(), $shoulderL->getZ(), $elbowL->getY(), $elbowL->getZ());

                        if (($handL = $this->userState->getHandLeft())) {
                            $this->node($handL->getY(), $handL->getZ());
                            $this->edge($elbowL->getY(), $elbowL->getZ(), $handL->getY(), $handL->getZ());
                        }
                    }
                }

                $this->setColor($this->getColor('edge'));
                $this->node($shoulderC->getY(), $shoulderC->getZ());
                $this->edge($head->getY(), $head->getZ(), $shoulderC->getY(), $shoulderC->getZ());
            }

            $this->setColor($this->getColor('head'));
            $this->nodeHead($head->getY(), $head->getZ());
        }


        return $this;
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


    /**
     * Calculate y coordinate
     * @param $yRaw
     * @param float $scale
     * @return mixed
     */
    public function x($yRaw, $scale = 0.015)
    {
        $yMax = (($this->yMax - $this->yMin) * $this->height);
        $scaleY = $this->height / $yMax;

        return (($yRaw - $this->yMin) * $this->height * $scaleY);
    }

    /**
     * Calculate z coordinate
     * @param $zRaw
     * @param float $scale
     * @return mixed
     */
    public function y($zRaw, $scale = 0.015)
    {
        $yMax = (($this->zMax - $this->zMin) * $this->height);
        $scaleY = $this->height / $yMax;

        return (($zRaw - $this->zMin) * $this->height * $scaleY);
    }

}