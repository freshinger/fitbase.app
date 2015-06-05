<?php

namespace Wellbeing\Bundle\ApiBundle\Imagick;


class ProjectionBuilderXZ extends ProjectionBuilderAbstract implements ProjectionBuilderInterface
{
    protected $width;
    protected $height;
    protected $scaleX;
    protected $scaleY;

    protected $userState;

    public function build()
    {
        parent::build();

        if (($head = $this->userState->getHead())) {

            if (($shoulderC = $this->userState->getShoulderCenter())) {

                if (($spine = $this->userState->getSpine())) {

                    if (($hipL = $this->userState->getHipLeft())) {

                        if (($kneeL = $this->userState->getKneeLeft())) {

                            $this->setColor($this->getColor('knee'));
                            $this->node($kneeL->getX(), $kneeL->getZ());
                            $this->edge($kneeL->getX(), $kneeL->getZ(), $hipL->getX(), $hipL->getZ());

                            if (($footL = $this->userState->getFootLeft())) {

                                $this->node($footL->getX(), $footL->getZ());
                                $this->edge($kneeL->getX(), $kneeL->getZ(), $footL->getX(), $footL->getZ());
                            }
                        }

                        $this->setColor($this->getColor('hip'));
                        $this->node($hipL->getX(), $hipL->getZ());
                        $this->edge($spine->getX(), $spine->getZ(), $hipL->getX(), $hipL->getZ());
                    }

                    if (($hipR = $this->userState->getHipRight())) {

                        if (($kneeR = $this->userState->getKneeRight())) {

                            $this->setColor($this->getColor('knee'));
                            $this->node($kneeR->getX(), $kneeR->getZ());
                            $this->edge($kneeR->getX(), $kneeR->getZ(), $hipR->getX(), $hipR->getZ());

                            if (($footR = $this->userState->getFootRight())) {

                                $this->node($footR->getX(), $footR->getZ());
                                $this->edge($kneeR->getX(), $kneeR->getZ(), $footR->getX(), $footR->getZ());
                            }
                        }

                        $this->setColor($this->getColor('hip'));
                        $this->node($hipR->getX(), $hipR->getZ());
                        $this->edge($spine->getX(), $spine->getZ(), $hipR->getX(), $hipR->getZ());

                        if (($hipL = $this->userState->getHipLeft())) {
                            $this->edge($hipL->getX(), $hipL->getZ(), $hipR->getX(), $hipR->getZ());
                        }
                    }

                    $this->setColor($this->getColor('spine'));
                    $this->node($spine->getX(), $spine->getZ());

                    if (($shoulderL = $this->userState->getShoulderLeft())) {
                        $this->edge($shoulderL->getX(), $shoulderL->getZ(), $spine->getX(), $spine->getZ());
                    }

                    if (($shoulderR = $this->userState->getShoulderRight())) {
                        $this->edge($shoulderR->getX(), $shoulderR->getZ(), $spine->getX(), $spine->getZ());
                    }
                }


                if (($shoulderR = $this->userState->getShoulderRight())) {

                    $this->setColor($this->getColor('edge'));
                    $this->edge($shoulderC->getX(), $shoulderC->getZ(), $shoulderR->getX(), $shoulderR->getZ());

                    $this->setColor($this->getColor('shoulder'));
                    $this->node($shoulderR->getX(), $shoulderR->getZ());

                    if (($elbowR = $this->userState->getElbowRight())) {

                        $this->node($elbowR->getX(), $elbowR->getZ());
                        $this->edge($shoulderR->getX(), $shoulderR->getZ(), $elbowR->getX(), $elbowR->getZ());

                        if (($handR = $this->userState->getHandRight())) {

                            $this->node($handR->getX(), $handR->getZ());
                            $this->edge($elbowR->getX(), $elbowR->getZ(), $handR->getX(), $handR->getZ());
                        }
                    }
                }

                if (($shoulderL = $this->userState->getShoulderLeft())) {

                    $this->setColor($this->getColor('edge'));
                    $this->edge($shoulderC->getX(), $shoulderC->getZ(), $shoulderL->getX(), $shoulderL->getZ());

                    $this->setColor($this->getColor('shoulder'));
                    $this->node($shoulderL->getX(), $shoulderL->getZ());

                    if (($elbowL = $this->userState->getElbowLeft())) {

                        $this->node($elbowL->getX(), $elbowL->getZ());
                        $this->edge($shoulderL->getX(), $shoulderL->getZ(), $elbowL->getX(), $elbowL->getZ());

                        if (($handL = $this->userState->getHandLeft())) {
                            $this->node($handL->getX(), $handL->getZ());
                            $this->edge($elbowL->getX(), $elbowL->getZ(), $handL->getX(), $handL->getZ());
                        }
                    }
                }

                $this->setColor($this->getColor('head'));
                $this->edge($head->getX(), $head->getZ(), $shoulderC->getX(), $shoulderC->getZ());
                $this->node($shoulderC->getX(), $shoulderC->getZ());
            }

            $this->setColor($this->getColor('head'));
            $this->nodeHead($head->getX(), $head->getZ());
        }

        return $this;
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