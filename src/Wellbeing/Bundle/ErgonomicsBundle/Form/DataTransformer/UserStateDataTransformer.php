<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/2/14
 * Time: 10:22 AM
 */

namespace Wellbeing\Bundle\ErgonomicsBundle\Form\DataTransformer;


use Symfony\Component\Form\DataTransformerInterface;
use Wellbeing\Bundle\ApiBundle\Model\UserState;
use Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomics;
use Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsElbowLeft;
use Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsElbowRight;
use Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsHandLeft;
use Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsHandRight;
use Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsHead;
use Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsHeadRotation;
use Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsLeanAmount;
use Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsNeck;
use Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsShoulderCenter;
use Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsShoulderLeft;
use Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsShoulderRight;
use Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsSpineBase;
use Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsSpineMid;
use Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomicsSpineShoulder;

class UserStateDataTransformer implements DataTransformerInterface
{
    /**
     * Transform from entity id to html
     * @param mixed $value
     * @return mixed|null
     */
    public function transform($value)
    {
        if (!$value instanceof UserStateErgonomics) {
            throw new \LogicException('Value should be an instance of UserStateErgonomics');
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

        if (($coordinates = $this->encodeXYZ($value->getHandLeft()))) {
            $model->setHandLeft($coordinates);
        }

        if (($coordinates = $this->encodeXYZ($value->getHandRight()))) {
            $model->setHandRight($coordinates);
        }

        if (($coordinates = $this->encodeXYZ($value->getSpineMid()))) {
            $model->setSpineMid($coordinates);
        }

        if (($coordinates = $this->encodeXYZ($value->getSpineBase()))) {
            $model->setSpineBase($coordinates);
        }

        if (($coordinates = $this->encodeXYZ($value->getSpineShoulder()))) {
            $model->setSpineShoulder($coordinates);
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

        $entity = (new UserStateErgonomics());

        if (($timestamp = $value->getTimestamp())) {
            $entity->setDate((new \DateTime())->setTimestamp($timestamp));
        }

        if (($coordinates = $this->decodeXYZ($value->getHead()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setHead(new UserStateErgonomicsHead($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getNeck()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setNeck(new UserStateErgonomicsNeck($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getShoulderCenter()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setShoulderCenter(new UserStateErgonomicsShoulderCenter($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getShoulderLeft()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setShoulderLeft(new UserStateErgonomicsShoulderLeft($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getShoulderRight()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setShoulderRight(new UserStateErgonomicsShoulderRight($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getElbowLeft()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setElbowLeft(new UserStateErgonomicsElbowLeft($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getElbowRight()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setElbowRight(new UserStateErgonomicsElbowRight($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getHandLeft()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setHandLeft(new UserStateErgonomicsHandLeft($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getHandRight()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setHandRight(new UserStateErgonomicsHandRight($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getSpineMid()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setSpineMid(new UserStateErgonomicsSpineMid($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getSpineBase()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setSpineBase(new UserStateErgonomicsSpineBase($x, $y, $z));
        }

        if (($coordinates = $this->decodeXYZ($value->getSpineShoulder()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setSpineShoulder(new UserStateErgonomicsSpineShoulder($x, $y, $z));
        }

        if (($coordinates = $this->decodeXY($value->getLeanAmount()))) {
            list ($x, $y) = $coordinates;
            $entity->setLeanAmount(new UserStateErgonomicsLeanAmount($x, $y));
        }

        if (($coordinates = $this->decodeXYZ($value->getHeadRotation()))) {
            list ($x, $y, $z) = $coordinates;
            $entity->setHeadRotation(new UserStateErgonomicsHeadRotation($x, $y, $z));
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