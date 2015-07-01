<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/2/14
 * Time: 10:22 AM
 */

namespace Wellbeing\Bundle\ExerciseBundle\Form\DataTransformer;


use Symfony\Component\Form\DataTransformerInterface;
use Wellbeing\Bundle\ApiBundle\Model\UserState;
use Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExercise;
use Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseAnkleLeft;
use Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseAnkleRight;
use Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseElbowLeft;
use Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseElbowRight;
use Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseFootLeft;
use Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseFootRight;
use Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHandLeft;
use Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHandRight;
use Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHandTipLeft;
use Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHandTipRight;
use Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHead;
use Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHeadRotation;
use Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHipLeft;
use Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseHipRight;
use Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseKneeLeft;
use Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseKneeRight;
use Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseLeanAmount;
use Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseLeftHandState;
use Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseNeck;
use Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseRightHandState;
use Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseShoulderCenter;
use Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseShoulderLeft;
use Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseShoulderRight;
use Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseSpineBase;
use Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseSpineMid;
use Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseThumbLeft;
use Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseThumbRight;
use Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseWristLeft;
use Wellbeing\Bundle\ExerciseBundle\Entity\UserStateExerciseWristRight;

class UserStateDataTransformer implements DataTransformerInterface
{
    /**
     * Transform from entity id to html
     * @param mixed $value
     * @return mixed|null
     */
    public function transform($value)
    {
        if (!$value instanceof UserStateExercise) {
            throw new \LogicException('Value should be an instance of UserStateExercise');
        }

        $model = new UserState();
        if (($date = $value->getDate()) instanceof \DateTime) {
            $model->setTimestamp($date->getTimestamp());
        }

        if (($coordinates = $this->encodeXYZ($value->getHead()))) {
            $model->setHead($coordinates);
        }

        if (($coordinates = $this->encodeXYZ($value->getNeck()))) {
            $model->setNeck($coordinates);
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

        if (($coordinates = $this->encodeXYZ($value->getElbowLeft()))) {
            $model->setElbowLeft($coordinates);
        }

        if (($coordinates = $this->encodeXYZ($value->getElbowRight()))) {
            $model->setElbowRight($coordinates);
        }

        if (($coordinates = $this->encodeXYZ($value->getWristLeft()))) {
            $model->setWristLeft($coordinates);
        }

        if (($coordinates = $this->encodeXYZ($value->getWristRight()))) {
            $model->setWristRight($coordinates);
        }

        if (($coordinates = $this->encodeXYZ($value->getHandLeft()))) {
            $model->setHandLeft($coordinates);
        }

        if (($coordinates = $this->encodeXYZ($value->getHandRight()))) {
            $model->setHandRight($coordinates);
        }

        if (($coordinates = $this->encodeXYZ($value->getThumbLeft()))) {
            $model->setThumbLeft($coordinates);
        }

        if (($coordinates = $this->encodeXYZ($value->getThumbRight()))) {
            $model->setThumbRight($coordinates);
        }

        if (($coordinates = $this->encodeXYZ($value->getHandTipLeft()))) {
            $model->setHandTipLeft($coordinates);
        }

        if (($coordinates = $this->encodeXYZ($value->getHandTipRight()))) {
            $model->setHandTipRight($coordinates);
        }

        if (($coordinates = $this->encodeXYZ($value->getSpineMid()))) {
            $model->setSpineMid($coordinates);
        }

        if (($coordinates = $this->encodeXYZ($value->getSpineBase()))) {
            $model->setSpineBase($coordinates);
        }

        if (($coordinates = $this->encodeXYZ($value->getHipLeft()))) {
            $model->setHipLeft($coordinates);
        }

        if (($coordinates = $this->encodeXYZ($value->getHipRight()))) {
            $model->setHipRight($coordinates);
        }

        if (($coordinates = $this->encodeXYZ($value->getKneeLeft()))) {
            $model->setKneeLeft($coordinates);
        }

        if (($coordinates = $this->encodeXYZ($value->getKneeRight()))) {
            $model->setKneeRight($coordinates);
        }

        if (($coordinates = $this->encodeXYZ($value->getAnkleLeft()))) {
            $model->setAnkleLeft($coordinates);
        }

        if (($coordinates = $this->encodeXYZ($value->getAnkleRight()))) {
            $model->setAnkleRight($coordinates);
        }

        if (($coordinates = $this->encodeXYZ($value->getFootLeft()))) {
            $model->setFootLeft($coordinates);
        }

        if (($coordinates = $this->encodeXYZ($value->getFootRight()))) {
            $model->setFootRight($coordinates);
        }

        if (($state = $value->getLeftHandState())) {
            $model->setLeftHandState($state->getValue());
        }

        if (($state = $value->getRightHandState())) {
            $model->setRightHandState($state->getValue());
        }

        if (($coordinates = $this->encodeXY($value->getLeanAmount()))) {
            $model->setLeanAmount($coordinates);
        }

        if (($coordinates = $this->encodeXYZ($value->getHeadRotation()))) {
            $model->setHeadRotation($coordinates);
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

        $entity = new UserStateExercise();
        if (($timestamp = $value->getTimestamp())) {
            $entity->setDate((new \DateTime())->setTimestamp($timestamp));
        }

        if (($coordinates = $this->decodeXYZ($value->getHead()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setHead(new UserStateExerciseHead($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getNeck()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setNeck(new UserStateExerciseNeck($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getShoulderCenter()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setShoulderCenter(new UserStateExerciseShoulderCenter($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getShoulderLeft()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setShoulderLeft(new UserStateExerciseShoulderLeft($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getShoulderRight()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setShoulderRight(new UserStateExerciseShoulderRight($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getElbowLeft()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setElbowLeft(new UserStateExerciseElbowLeft($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getElbowRight()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setElbowRight(new UserStateExerciseElbowRight($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getWristLeft()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setWristLeft(new UserStateExerciseWristLeft($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getWristRight()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setWristRight(new UserStateExerciseWristRight($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getHandLeft()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setHandLeft(new UserStateExerciseHandLeft($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getHandRight()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setHandRight(new UserStateExerciseHandRight($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getThumbLeft()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setThumbLeft(new UserStateExerciseThumbLeft($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getThumbRight()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setThumbRight(new UserStateExerciseThumbRight($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getHandTipLeft()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setHandTipLeft(new UserStateExerciseHandTipLeft($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getHandTipRight()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setHandTipRight(new UserStateExerciseHandTipRight($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getSpineMid()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setSpineMid(new UserStateExerciseSpineMid($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getSpineBase()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setSpineBase(new UserStateExerciseSpineBase($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getHipLeft()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setHipLeft(new UserStateExerciseHipLeft($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getHipRight()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setHipRight(new UserStateExerciseHipRight($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getKneeLeft()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setKneeLeft(new UserStateExerciseKneeLeft($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getKneeRight()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setKneeRight(new UserStateExerciseKneeRight($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getAnkleLeft()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setAnkleLeft(new UserStateExerciseAnkleLeft($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getAnkleRight()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setAnkleRight(new UserStateExerciseAnkleRight($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getFootLeft()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setFootLeft(new UserStateExerciseFootLeft($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getFootRight()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setFootRight(new UserStateExerciseFootRight($x, $y, $z));
        }

        $entity->setLeftHandState(new UserStateExerciseLeftHandState($value->getLeftHandState()));
        $entity->setRightHandState(new UserStateExerciseRightHandState($value->getRightHandState()));

        if (($coordinates = $this->decodeXY($value->getLeanAmount()))) {
            list ($x, $y) = $coordinates;
            $entity->setLeanAmount(new UserStateExerciseLeanAmount($x, $y));
        }

        if (($coordinates = $this->decodeXYZ($value->getHeadRotation()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setHeadRotation(new UserStateExerciseHeadRotation($x, $y, $z));
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