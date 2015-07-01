<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/2/14
 * Time: 10:22 AM
 */

namespace Wellbeing\Bundle\StressBundle\Form\DataTransformer;


use Symfony\Component\Form\DataTransformerInterface;
use Wellbeing\Bundle\ApiBundle\Entity\Coordinate;
use Wellbeing\Bundle\ApiBundle\Model\UserState;
use Wellbeing\Bundle\StressBundle\Entity\UserStateStress;
use Wellbeing\Bundle\StressBundle\Entity\UserStateStressHandLeft;
use Wellbeing\Bundle\StressBundle\Entity\UserStateStressHandRight;
use Wellbeing\Bundle\StressBundle\Entity\UserStateStressHappy;
use Wellbeing\Bundle\StressBundle\Entity\UserStateStressHead;
use Wellbeing\Bundle\StressBundle\Entity\UserStateStressHeadRotation;
use Wellbeing\Bundle\StressBundle\Entity\UserStateStressHeartRate;
use Wellbeing\Bundle\StressBundle\Entity\UserStateStressJawOpen;
use Wellbeing\Bundle\StressBundle\Entity\UserStateStressJawSlideRight;
use Wellbeing\Bundle\StressBundle\Entity\UserStateStressLeanAmount;
use Wellbeing\Bundle\StressBundle\Entity\UserStateStressLeftCheekPuff;
use Wellbeing\Bundle\StressBundle\Entity\UserStateStressLeftEyeBrowLowerer;
use Wellbeing\Bundle\StressBundle\Entity\UserStateStressLeftEyeClosed;
use Wellbeing\Bundle\StressBundle\Entity\UserStateStressLipCornerDepressorLeft;
use Wellbeing\Bundle\StressBundle\Entity\UserStateStressLipCornerDepressorRight;
use Wellbeing\Bundle\StressBundle\Entity\UserStateStressLipCornerPullerLeft;
use Wellbeing\Bundle\StressBundle\Entity\UserStateStressLipCornerPullerRight;
use Wellbeing\Bundle\StressBundle\Entity\UserStateStressLipPucker;
use Wellbeing\Bundle\StressBundle\Entity\UserStateStressLipStretcherLeft;
use Wellbeing\Bundle\StressBundle\Entity\UserStateStressLipStretcherRight;
use Wellbeing\Bundle\StressBundle\Entity\UserStateStressLowerLipDepressorLeft;
use Wellbeing\Bundle\StressBundle\Entity\UserStateStressLowerLipDepressorRight;
use Wellbeing\Bundle\StressBundle\Entity\UserStateStressRightCheekPuff;
use Wellbeing\Bundle\StressBundle\Entity\UserStateStressRightEyeBrowLowerer;
use Wellbeing\Bundle\StressBundle\Entity\UserStateStressRightEyeClosed;
use Wellbeing\Bundle\StressBundle\Entity\UserStateStressShoulderCenter;
use Wellbeing\Bundle\StressBundle\Entity\UserStateStressShoulderLeft;
use Wellbeing\Bundle\StressBundle\Entity\UserStateStressShoulderRight;

class UserStateDataTransformer implements DataTransformerInterface
{
    /**
     * Transform from entity id to html
     * @param mixed $value
     * @return mixed|null
     */
    public function transform($value)
    {
        if (!$value instanceof UserStateStress) {
            throw new \LogicException('Value should be an instance of UserStateStress');
        }

        $model = new UserState();
        if (($date = $value->getDate()) instanceof \DateTime) {
            $model->setTimestamp($date->getTimestamp());
        }

        if (($state = $value->getJawOpen())) {
            $model->setJawOpen($state->getValue());
        }

        if (($state = $value->getLipPucker())) {
            $model->setLipPucker($state->getValue());
        }

        if (($state = $value->getJawSlideRight())) {
            $model->setJawSlideRight($state->getValue());
        }

        if (($state = $value->getLipStretcherLeft())) {
            $model->setLipStretcherLeft($state->getValue());
        }

        if (($state = $value->getLipStretcherRight())) {
            $model->setLipStretcherRight($state->getValue());
        }

        if (($state = $value->getLipCornerPullerLeft())) {
            $model->setLipCornerPullerLeft($state->getValue());
        }

        if (($state = $value->getLipCornerPullerRight())) {
            $model->setLipCornerPullerRight($state->getValue());
        }

        if (($state = $value->getLipCornerDepressorLeft())) {
            $model->setLipCornerDepressorLeft($state->getValue());
        }

        if (($state = $value->getLipCornerDepressorRight())) {
            $model->setLipCornerDepressorRight($state->getValue());
        }

        if (($state = $value->getLeftCheekPuff())) {
            $model->setLeftCheekPuff($state->getValue());
        }

        if (($state = $value->getRightCheekPuff())) {
            $model->setRightCheekPuff($state->getValue());
        }

        if (($state = $value->getLeftEyeClosed())) {
            $model->setLeftEyeClosed($state->getValue());
        }

        if (($state = $value->getRightEyeClosed())) {
            $model->setRightEyeClosed($state->getValue());
        }

        if (($state = $value->getRightEyeBrowLowerer())) {
            $model->setRightEyeBrowLowerer($state->getValue());
        }

        if (($state = $value->getLeftEyeBrowLowerer())) {
            $model->setLeftEyeBrowLowerer($state->getValue());
        }

        if (($state = $value->getLowerLipDepressorLeft())) {
            $model->setLowerLipDepressorLeft($state->getValue());
        }

        if (($state = $value->getLowerLipDepressorRight())) {
            $model->setLowerLipDepressorRight($state->getValue());
        }

        if (($state = $value->getHappy())) {
            $model->setHappy($state->getValue());
        }

        if (($coordinates = $this->encodeXYZ($value->getHead()))) {
            $model->setHead($coordinates);
        }

        if (($coordinates = $this->encodeXYZ($value->getShoulderCenter()))) {
            $model->setShoulderCenter($coordinates);
        }

        if (($coordinates = $this->encodeXYZ($value->getShoulderLeft()))) {
            $model->setShoulderLeft($coordinates);
        }

        if (($coordinates = $this->encodeXYZ($value->getShoulderRight()))) {
            $model->setShoulderRight($coordinates);
        }

        if (($coordinates = $this->encodeXYZ($value->getHandLeft()))) {
            $model->setHandLeft($coordinates);
        }

        if (($coordinates = $this->encodeXYZ($value->getHandRight()))) {
            $model->setHandRight($coordinates);
        }

        if (($coordinates = $this->encodeXY($value->getLeanAmount()))) {
            $model->setLeanAmount($coordinates);
        }

        if (($coordinates = $this->encodeXYZ($value->getHeadRotation()))) {
            $model->setHeadRotation($coordinates);
        }

        if (($state = $value->getHeartRate())) {
            $model->setHeartRate($state->getValue());
        }

        return $model;
    }

    /**
     * Encode XYZ coordinates to string
     *
     * @param $entity
     * @return string
     */
    public function encodeXYZ($entity)
    {
        return "{$entity->getX()};{$entity->getY()};{$entity->getZ()}";
    }

    /**
     * Encode XY coordinates to string
     *
     * @param $entity
     * @return string
     */
    public function encodeXY($entity)
    {
        return "{$entity->getX()};{$entity->getY()}";
    }

    /**
     * Transform from html to entity id
     * @param mixed $value
     * @return mixed|null
     */
    public function reverseTransform($value)
    {
        if (!$value instanceof UserState) {
            throw new \LogicException('Value should be an instance of UserState');
        }

        $entity = new UserStateStress();
        if (($timestamp = $value->getTimestamp())) {
            $entity->setDate((new \DateTime())->setTimestamp($timestamp));
        }

        $entity->setJawOpen(new UserStateStressJawOpen($value->getJawOpen()));
        $entity->setLipPucker(new UserStateStressLipPucker($value->getLipPucker()));
        $entity->setJawSlideRight(new UserStateStressJawSlideRight($value->getJawSlideRight()));
        $entity->setLipStretcherLeft(new UserStateStressLipStretcherLeft($value->getLipStretcherLeft()));
        $entity->setLipStretcherRight(new UserStateStressLipStretcherRight($value->getLipStretcherRight()));
        $entity->setLipCornerPullerLeft(new UserStateStressLipCornerPullerLeft($value->getLipCornerPullerLeft()));
        $entity->setLipCornerPullerRight(new UserStateStressLipCornerPullerRight($value->getLipCornerPullerRight()));
        $entity->setLipCornerDepressorLeft(new UserStateStressLipCornerDepressorLeft($value->getLipCornerDepressorLeft()));
        $entity->setLipCornerDepressorRight(new UserStateStressLipCornerDepressorRight($value->getLipCornerDepressorRight()));
        $entity->setLeftCheekPuff(new UserStateStressLeftCheekPuff($value->getLeftCheekPuff()));
        $entity->setRightCheekPuff(new UserStateStressRightCheekPuff($value->getRightCheekPuff()));
        $entity->setLeftEyeClosed(new UserStateStressLeftEyeClosed($value->getLeftEyeClosed()));
        $entity->setRightEyeClosed(new UserStateStressRightEyeClosed($value->getRightEyeClosed()));
        $entity->setRightEyeBrowLowerer(new UserStateStressRightEyeBrowLowerer($value->getRightEyeBrowLowerer()));
        $entity->setLeftEyeBrowLowerer(new UserStateStressLeftEyeBrowLowerer($value->getLeftEyeBrowLowerer()));
        $entity->setLowerLipDepressorLeft(new UserStateStressLowerLipDepressorLeft($value->getLowerLipDepressorLeft()));
        $entity->setLowerLipDepressorRight(new UserStateStressLowerLipDepressorRight($value->getLowerLipDepressorRight()));
        $entity->setHappy(new UserStateStressHappy($value->getHappy()));
        $entity->setHeartRate(new UserStateStressHeartRate($value->getHeartRate()));

        if (($coordinates = $this->decodeXYZ($value->getHead()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setHead(new UserStateStressHead($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getShoulderCenter()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setShoulderCenter(new UserStateStressShoulderCenter($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getShoulderLeft()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setShoulderLeft(new UserStateStressShoulderLeft($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getShoulderRight()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setShoulderRight(new UserStateStressShoulderRight($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getHandLeft()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setHandLeft(new UserStateStressHandLeft($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getHandRight()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setHandRight(new UserStateStressHandRight($x, $y, $z));
        }

        if (($coordinates = $this->decodeXY($value->getLeanAmount()))) {
            list ($x, $y) = $coordinates;
            $entity->setLeanAmount(new UserStateStressLeanAmount($x, $y));
        }

        if (($coordinates = $this->decodeXYZ($value->getHeadRotation()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setHeadRotation(new UserStateStressHeadRotation($x, $y, $z));
        }


        return $entity;
    }

    /**
     * Parse X;Y;Z coordinates from string
     *
     * @param $value
     * @return array|null
     */
    protected function decodeXYZ($value)
    {
        if (($coordinates = explode(';', $value)) and count($coordinates) == 3) {
            return $coordinates;
        }
        return null;
    }

    /**
     * Parse X;Y
     *
     * @param $value
     * @return array|null
     */
    protected function decodeXY($value)
    {
        if (($coordinates = explode(';', $value)) and count($coordinates) == 2) {
            return $coordinates;
        }
        return null;
    }
}