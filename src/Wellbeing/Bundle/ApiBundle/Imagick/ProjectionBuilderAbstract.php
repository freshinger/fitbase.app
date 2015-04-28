<?php

namespace Wellbeing\Bundle\ApiBundle\Imagick;


abstract class ProjectionBuilderAbstract extends \ImagickDraw
{
    public function __construct()
    {
        parent::__construct();

        $this->setColor('blue');
        $this->setStrokeWidth(4);
        $this->setStrokeAntialias(true);
    }

    /**
     * @param $yRaw
     * @param $zRaw
     */
    abstract protected function node($yRaw, $zRaw);

    /**
     * Draw a head
     * @param $xRaw
     * @param $yRaw
     * @param float $scale
     */
    protected function nodeHead($xRaw, $yRaw, $scale = 0.04)
    {
        return $this->node($xRaw, $yRaw, $scale);
    }

    /**
     * Draw a edge
     * @param $y1Raw
     * @param $z1Raw
     * @param $y2Raw
     * @param $z2Raw
     */
    abstract protected function edge($y1Raw, $z1Raw, $y2Raw, $z2Raw);

    /**
     * Set color for elements
     * @param $color
     */
    protected function setColor($color)
    {
        $this->setFillColor($color);
        $this->setStrokeColor($color);
    }

}