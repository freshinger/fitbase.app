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

            if ($value->getHead() instanceof Coordinate) {
                $model->setHead("{$value->getHead()->getX()};{$value->getHead()->getY()};{$value->getHead()->getZ()}");
            }

            if ($value->getShoulderLeft() instanceof Coordinate) {
                $model->setShoulderLeft("{$value->getShoulderLeft()->getX()};{$value->getShoulderLeft()->getY()};{$value->getShoulderLeft()->getZ()}");
            }

            if ($value->getShoulderCenter() instanceof Coordinate) {
                $model->setShoulderCenter("{$value->getShoulderCenter()->getX()};{$value->getShoulderCenter()->getY()};{$value->getShoulderCenter()->getZ()}");
            }

            if ($value->getShoulderRight() instanceof Coordinate) {
                $model->setShoulderRight("{$value->getShoulderRight()->getX()};{$value->getShoulderRight()->getY()};{$value->getShoulderRight()->getZ()}");
            }

            if ($value->getElbowLeft() instanceof Coordinate) {
                $model->setElbowLeft("{$value->getElbowLeft()->getX()};{$value->getElbowLeft()->getY()};{$value->getElbowLeft()->getZ()}");
            }

            if ($value->getElbowRight() instanceof Coordinate) {
                $model->setElbowRight("{$value->getElbowRight()->getX()};{$value->getElbowRight()->getY()};{$value->getElbowRight()->getZ()}");
            }

            if ($value->getHandLeft() instanceof Coordinate) {
                $model->setHandLeft("{$value->getHandLeft()->getX()};{$value->getHandLeft()->getY()};{$value->getHandLeft()->getZ()}");
            }

            if ($value->getHandRight() instanceof Coordinate) {
                $model->setHandRight("{$value->getHandRight()->getX()};{$value->getHandRight()->getY()};{$value->getHandRight()->getZ()}");
            }

            if ($value->getCom() instanceof Coordinate) {
                $model->setCom("{$value->getCom()->getX()};{$value->getCom()->getY()};{$value->getCom()->getZ()}");
            }

            if ($value->getSpine() instanceof Coordinate) {
                $model->setSpine("{$value->getSpine()->getX()};{$value->getSpine()->getY()};{$value->getSpine()->getZ()}");
            }

            if ($value->getHipLeft() instanceof Coordinate) {
                $model->setHipLeft("{$value->getHipLeft()->getX()};{$value->getHipLeft()->getY()};{$value->getHipLeft()->getZ()}");
            }

            if ($value->getHipRight() instanceof Coordinate) {
                $model->setHipRight("{$value->getHipRight()->getX()};{$value->getHipRight()->getY()};{$value->getHipRight()->getZ()}");
            }

            if ($value->getKneeLeft() instanceof Coordinate) {
                $model->setKneeLeft("{$value->getKneeLeft()->getX()};{$value->getKneeLeft()->getY()};{$value->getKneeLeft()->getZ()}");
            }

            if ($value->getKneeRight() instanceof Coordinate) {
                $model->setKneeRight("{$value->getKneeRight()->getX()};{$value->getKneeRight()->getY()};{$value->getKneeRight()->getZ()}");
            }

            if ($value->getFootLeft() instanceof Coordinate) {
                $model->setFootLeft("{$value->getFootLeft()->getX()};{$value->getFootLeft()->getY()};{$value->getFootLeft()->getZ()}");
            }

            if ($value->getFootRight() instanceof Coordinate) {
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
                    (new Coordinate())
                        ->setX((float)$x)
                        ->setY((float)$y)
                        ->setZ((float)$z)
                );
            }
            if (($coordinates = explode(';', $value->getShoulderLeft())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setShoulderLeft(
                    (new Coordinate())
                        ->setX((float)$x)
                        ->setY((float)$y)
                        ->setZ((float)$z)
                );
            }
            if (($coordinates = explode(';', $value->getShoulderCenter())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setShoulderCenter(
                    (new Coordinate())
                        ->setX((float)$x)
                        ->setY((float)$y)
                        ->setZ((float)$z)
                );
            }
            if (($coordinates = explode(';', $value->getShoulderRight())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setShoulderRight(
                    (new Coordinate())
                        ->setX((float)$x)
                        ->setY((float)$y)
                        ->setZ((float)$z)
                );
            }
            if (($coordinates = explode(';', $value->getElbowLeft())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setElbowLeft(
                    (new Coordinate())
                        ->setX((float)$x)
                        ->setY((float)$y)
                        ->setZ((float)$z)
                );
            }
            if (($coordinates = explode(';', $value->getElbowRight())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setElbowRight(
                    (new Coordinate())
                        ->setX((float)$x)
                        ->setY((float)$y)
                        ->setZ((float)$z)
                );
            }

            if (($coordinates = explode(';', $value->getHandLeft())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setHandLeft(
                    (new Coordinate())
                        ->setX((float)$x)
                        ->setY((float)$y)
                        ->setZ((float)$z)
                );
            }

            if (($coordinates = explode(';', $value->getHandRight())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setHandRight(
                    (new Coordinate())
                        ->setX((float)$x)
                        ->setY((float)$y)
                        ->setZ((float)$z)
                );
            }

            if (($coordinates = explode(';', $value->getCom())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setCom(
                    (new Coordinate())
                        ->setX((float)$x)
                        ->setY((float)$y)
                        ->setZ((float)$z)
                );
            }

            if (($coordinates = explode(';', $value->getSpine())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setSpine(
                    (new Coordinate())
                        ->setX((float)$x)
                        ->setY((float)$y)
                        ->setZ((float)$z)
                );
            }

            if (($coordinates = explode(';', $value->getHipLeft())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setHipLeft(
                    (new Coordinate())
                        ->setX((float)$x)
                        ->setY((float)$y)
                        ->setZ((float)$z)
                );
            }

            if (($coordinates = explode(';', $value->getHipRight())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setHipRight(
                    (new Coordinate())
                        ->setX((float)$x)
                        ->setY((float)$y)
                        ->setZ((float)$z)
                );
            }

            if (($coordinates = explode(';', $value->getKneeLeft())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setKneeLeft(
                    (new Coordinate())
                        ->setX((float)$x)
                        ->setY((float)$y)
                        ->setZ((float)$z)
                );
            }

            if (($coordinates = explode(';', $value->getKneeRight())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setKneeRight(
                    (new Coordinate())
                        ->setX((float)$x)
                        ->setY((float)$y)
                        ->setZ((float)$z)
                );
            }

            if (($coordinates = explode(';', $value->getFootLeft())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setFootLeft(
                    (new Coordinate())
                        ->setX((float)$x)
                        ->setY((float)$y)
                        ->setZ((float)$z)
                );
            }

            if (($coordinates = explode(';', $value->getFootRight())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setFootRight(
                    (new Coordinate())
                        ->setX((float)$x)
                        ->setY((float)$y)
                        ->setZ((float)$z)
                );
            }
        }

        return $entity;
    }
}