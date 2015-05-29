<?php

namespace Wellbeing\Bundle\ApiBundle\Imagick;

use Wellbeing\Bundle\ApiBundle\Entity\UserState;
use Wellbeing\Bundle\ApiBundle\Imagick\Patcher\ProjectionBuilderPatcherInterface;


abstract class ProjectionBuilderAbstract extends \ImagickDraw
{
    protected $colorize;
    protected $patchers = [];
    protected $width;
    protected $height;
    protected $userState;

    protected $xMin;
    protected $xMax;
    protected $yMin;
    protected $yMax;
    protected $zMin;
    protected $zMax;

    public function __construct($width, $height, UserState $userState, $colorize = true)
    {
        $this->width = $width;
        $this->height = $height;
        $this->userState = $userState;
        $this->colorize = $colorize;

        $this->xMin = $userState->getMinXCoordinate();
        $this->yMin = $userState->getMinYCoordinate();

        $this->xMax = $userState->getMaxXCoordinate();
        $this->yMax = $userState->getMaxYCoordinate();

        $this->zMin = $userState->getMinZCoordinate();
        $this->zMax = $userState->getMaxZCoordinate();

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
     * Return part-specified color
     * @param $code
     * @return string
     */
    protected function getColor($code)
    {
        if ($this->colorize) {
            switch ($code) {
                case 'edge':
                case 'head':
                    return 'green';
                case 'shoulder':
                    return 'red';
                case 'hip':
                case 'spine':
                    return 'blue';
                case 'knee':
                    return 'grey';
            }
        }
        return 'black';
    }


    /**
     * @param $color
     * @return $this
     */
    public function setColor($color)
    {
        $this->setFillColor($color);
        $this->setStrokeColor($color);

        return $this;
    }

    /**
     * Calculate x coordinate
     * @param $xRaw
     * @param float $scale
     * @return mixed
     */
    public function x($xRaw, $scale = 0.015)
    {
        $xMax = (($this->xMax - $this->xMin) * $this->width);
        $scaleX = $this->width / $xMax;

        return (($xRaw - $this->xMin) * $this->width * $scaleX);
    }

    /**
     * Calculate y coordinate
     * @param $yRaw
     * @param float $scale
     * @return mixed
     */
    public function y($yRaw, $scale = 0.015)
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
    public function z($zRaw, $scale = 0.015)
    {
        $yMax = (($this->zMax - $this->zMin) * $this->height);
        $scaleY = $this->height / $yMax;

        return (($zRaw - $this->zMin) * $this->height * $scaleY);
    }


    /**
     * Build a image from
     * a set of coordinates
     */
    public function build()
    {
        if (!empty($this->patchers)) {
            foreach ($this->patchers as $patcher) {
                $patcher->patch($this, $this->userState);
            }
        }

        return $this;
    }

    /**
     * @param ProjectionBuilderPatcherInterface $patcher
     * @return $this
     */
    public function addPatcher(ProjectionBuilderPatcherInterface $patcher)
    {
        array_push($this->patchers, $patcher);

        return $this;
    }

}