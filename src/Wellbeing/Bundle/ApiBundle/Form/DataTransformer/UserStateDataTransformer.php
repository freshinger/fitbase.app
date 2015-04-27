<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/2/14
 * Time: 10:22 AM
 */

namespace Wellbeing\Bundle\ApiBundle\Form\DataTransformer;


use Symfony\Component\Form\DataTransformerInterface;
use Wellbeing\Bundle\ApiBundle\Entity\Coordinate;
use Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateCom;
use Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateElbowLeft;
use Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateElbowRight;
use Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateFootLeft;
use Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateFootRight;
use Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateHandLeft;
use Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateHandRight;
use Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateHead;
use Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateHipLeft;
use Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateHipRight;
use Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateKneeLeft;
use Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateKneeRight;
use Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateShoulderCenter;
use Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateShoulderLeft;
use Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateShoulderRight;
use Wellbeing\Bundle\ApiBundle\Entity\UserCoordinateSpine;
use Wellbeing\Bundle\ApiBundle\Model\UserState;

class UserStateDataTransformer implements DataTransformerInterface
{
    /**
     * Transform from entity id to html
     * @param mixed $value
     * @return mixed|null
     */
    public function transform($value)
    {
        $model = new UserState();
        if ($value instanceof \Wellbeing\Bundle\ApiBundle\Entity\UserState) {
            $model->setId($value->getId());
            $model->setAuthKey($value->getAuthKey());
            if ($value->getDate() instanceof \DateTime) {
                $model->setTimestamp($value->getDate()->getTimestamp());
            }

            if ($value->getHead() instanceof UserCoordinateHead) {
                $model->setHead("{$value->getHead()->getX()};{$value->getHead()->getY()};{$value->getHead()->getZ()}");
            }

            if ($value->getShoulderLeft() instanceof UserCoordinateShoulderLeft) {
                $model->setShoulderLeft("{$value->getShoulderLeft()->getX()};{$value->getShoulderLeft()->getY()};{$value->getShoulderLeft()->getZ()}");
            }

            if ($value->getShoulderCenter() instanceof UserCoordinateShoulderCenter) {
                $model->setShoulderCenter("{$value->getShoulderCenter()->getX()};{$value->getShoulderCenter()->getY()};{$value->getShoulderCenter()->getZ()}");
            }

            if ($value->getShoulderRight() instanceof UserCoordinateShoulderRight) {
                $model->setShoulderRight("{$value->getShoulderRight()->getX()};{$value->getShoulderRight()->getY()};{$value->getShoulderRight()->getZ()}");
            }

            if ($value->getElbowLeft() instanceof UserCoordinateElbowLeft) {
                $model->setElbowLeft("{$value->getElbowLeft()->getX()};{$value->getElbowLeft()->getY()};{$value->getElbowLeft()->getZ()}");
            }

            if ($value->getElbowRight() instanceof UserCoordinateElbowRight) {
                $model->setElbowRight("{$value->getElbowRight()->getX()};{$value->getElbowRight()->getY()};{$value->getElbowRight()->getZ()}");
            }

            if ($value->getHandLeft() instanceof UserCoordinateHandLeft) {
                $model->setHandLeft("{$value->getHandLeft()->getX()};{$value->getHandLeft()->getY()};{$value->getHandLeft()->getZ()}");
            }

            if ($value->getHandRight() instanceof UserCoordinateHandRight) {
                $model->setHandRight("{$value->getHandRight()->getX()};{$value->getHandRight()->getY()};{$value->getHandRight()->getZ()}");
            }

            if ($value->getCom() instanceof UserCoordinateCom) {
                $model->setCom("{$value->getCom()->getX()};{$value->getCom()->getY()};{$value->getCom()->getZ()}");
            }

            if ($value->getSpine() instanceof UserCoordinateSpine) {
                $model->setSpine("{$value->getSpine()->getX()};{$value->getSpine()->getY()};{$value->getSpine()->getZ()}");
            }

            if ($value->getHipLeft() instanceof UserCoordinateHipLeft) {
                $model->setHipLeft("{$value->getHipLeft()->getX()};{$value->getHipLeft()->getY()};{$value->getHipLeft()->getZ()}");
            }

            if ($value->getHipRight() instanceof UserCoordinateHipRight) {
                $model->setHipRight("{$value->getHipRight()->getX()};{$value->getHipRight()->getY()};{$value->getHipRight()->getZ()}");
            }

            if ($value->getKneeLeft() instanceof UserCoordinateKneeLeft) {
                $model->setKneeLeft("{$value->getKneeLeft()->getX()};{$value->getKneeLeft()->getY()};{$value->getKneeLeft()->getZ()}");
            }

            if ($value->getKneeRight() instanceof UserCoordinateKneeRight) {
                $model->setKneeRight("{$value->getKneeRight()->getX()};{$value->getKneeRight()->getY()};{$value->getKneeRight()->getZ()}");
            }

            if ($value->getFootLeft() instanceof UserCoordinateFootLeft) {
                $model->setFootLeft("{$value->getFootLeft()->getX()};{$value->getFootLeft()->getY()};{$value->getFootLeft()->getZ()}");
            }

            if ($value->getFootRight() instanceof UserCoordinateFootRight) {
                $model->setFootRight("{$value->getFootRight()->getX()};{$value->getFootRight()->getY()};{$value->getFootRight()->getZ()}");
            }
        }

        return $model;
    }

    /**
     * Transform from html to entity id
     * @param mixed $value
     * @return mixed|null
     */
    public function reverseTransform($value)
    {
        $entity = new \Wellbeing\Bundle\ApiBundle\Entity\UserState();
        if ($value instanceof UserState) {
            $entity->setAuthKey($value->getAuthKey());
            $entity->setDate((new \DateTime())->setTimestamp($value->getTimestamp()));
            if (($coordinates = explode(';', $value->getHead())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setHead(
                    (new UserCoordinateHead())
                        ->setX((float)$x)
                        ->setY((float)$y)
                        ->setZ((float)$z)
                );
            }
            if (($coordinates = explode(';', $value->getShoulderLeft())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setShoulderLeft(
                    (new UserCoordinateShoulderLeft())
                        ->setX((float)$x)
                        ->setY((float)$y)
                        ->setZ((float)$z)
                );
            }
            if (($coordinates = explode(';', $value->getShoulderCenter())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setShoulderCenter(
                    (new UserCoordinateShoulderCenter())
                        ->setX((float)$x)
                        ->setY((float)$y)
                        ->setZ((float)$z)
                );
            }
            if (($coordinates = explode(';', $value->getShoulderRight())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setShoulderRight(
                    (new UserCoordinateShoulderRight())
                        ->setX((float)$x)
                        ->setY((float)$y)
                        ->setZ((float)$z)
                );
            }
            if (($coordinates = explode(';', $value->getElbowLeft())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setElbowLeft(
                    (new UserCoordinateElbowLeft())
                        ->setX((float)$x)
                        ->setY((float)$y)
                        ->setZ((float)$z)
                );
            }
            if (($coordinates = explode(';', $value->getElbowRight())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setElbowRight(
                    (new UserCoordinateElbowRight())
                        ->setX((float)$x)
                        ->setY((float)$y)
                        ->setZ((float)$z)
                );
            }

            if (($coordinates = explode(';', $value->getHandLeft())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setHandLeft(
                    (new UserCoordinateHandLeft())
                        ->setX((float)$x)
                        ->setY((float)$y)
                        ->setZ((float)$z)
                );
            }

            if (($coordinates = explode(';', $value->getHandRight())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setHandRight(
                    (new UserCoordinateHandRight())
                        ->setX((float)$x)
                        ->setY((float)$y)
                        ->setZ((float)$z)
                );
            }

            if (($coordinates = explode(';', $value->getCom())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setCom(
                    (new UserCoordinateCom())
                        ->setX((float)$x)
                        ->setY((float)$y)
                        ->setZ((float)$z)
                );
            }

            if (($coordinates = explode(';', $value->getSpine())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setSpine(
                    (new UserCoordinateSpine())
                        ->setX((float)$x)
                        ->setY((float)$y)
                        ->setZ((float)$z)
                );
            }

            if (($coordinates = explode(';', $value->getHipLeft())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setHipLeft(
                    (new UserCoordinateHipLeft())
                        ->setX((float)$x)
                        ->setY((float)$y)
                        ->setZ((float)$z)
                );
            }

            if (($coordinates = explode(';', $value->getHipRight())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setHipRight(
                    (new UserCoordinateHipRight())
                        ->setX((float)$x)
                        ->setY((float)$y)
                        ->setZ((float)$z)
                );
            }

            if (($coordinates = explode(';', $value->getKneeLeft())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setKneeLeft(
                    (new UserCoordinateKneeLeft())
                        ->setX((float)$x)
                        ->setY((float)$y)
                        ->setZ((float)$z)
                );
            }

            if (($coordinates = explode(';', $value->getKneeRight())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setKneeRight(
                    (new UserCoordinateKneeRight())
                        ->setX((float)$x)
                        ->setY((float)$y)
                        ->setZ((float)$z)
                );
            }

            if (($coordinates = explode(';', $value->getFootLeft())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setFootLeft(
                    (new UserCoordinateFootLeft())
                        ->setX((float)$x)
                        ->setY((float)$y)
                        ->setZ((float)$z)
                );
            }

            if (($coordinates = explode(';', $value->getFootRight())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setFootRight(
                    (new UserCoordinateFootRight())
                        ->setX((float)$x)
                        ->setY((float)$y)
                        ->setZ((float)$z)
                );
            }
        }

        return $entity;
    }
}