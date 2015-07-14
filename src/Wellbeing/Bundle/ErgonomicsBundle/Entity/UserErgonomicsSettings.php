<?php

namespace Wellbeing\Bundle\ErgonomicsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserErgonomicsSettings
 */
class UserErgonomicsSettings
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var float
     */
    private $upper;

    /**
     * @var float
     */
    private $upperError;

    /**
     * @var float
     */
    private $lower;

    /**
     * @var float
     */
    private $lowerError;

    /**
     * @var float
     */
    private $range;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set code
     *
     * @param string $code
     * @return UserErgonomicsSettings
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set upper
     *
     * @param float $upper
     * @return UserErgonomicsSettings
     */
    public function setUpper($upper)
    {
        $this->upper = $upper;

        return $this;
    }

    /**
     * Get upper
     *
     * @return float
     */
    public function getUpper()
    {
        return $this->upper;
    }

    /**
     * Set upperError
     *
     * @param float $upperError
     * @return UserErgonomicsSettings
     */
    public function setUpperError($upperError)
    {
        $this->upperError = $upperError;

        return $this;
    }

    /**
     * Get upperError
     *
     * @return float
     */
    public function getUpperError()
    {
        return $this->upperError;
    }

    /**
     * Set lower
     *
     * @param float $lower
     * @return UserErgonomicsSettings
     */
    public function setLower($lower)
    {
        $this->lower = $lower;

        return $this;
    }

    /**
     * Get lower
     *
     * @return float
     */
    public function getLower()
    {
        return $this->lower;
    }

    /**
     * Set lowerError
     *
     * @param float $lowerError
     * @return UserErgonomicsSettings
     */
    public function setLowerError($lowerError)
    {
        $this->lowerError = $lowerError;

        return $this;
    }

    /**
     * Get lowerError
     *
     * @return float
     */
    public function getLowerError()
    {
        return $this->lowerError;
    }

    /**
     * Set range
     *
     * @param float $range
     * @return UserErgonomicsSettings
     */
    public function setRange($range)
    {
        $this->range = $range;

        return $this;
    }

    /**
     * Get range
     *
     * @return float
     */
    public function getRange()
    {
        return $this->range;
    }

    /**
     * Code from Rainer
     *
     * @return float
     */
    public function getRangeOriginal()
    {
        return $this->getRange() / (1.96 * 2);
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
