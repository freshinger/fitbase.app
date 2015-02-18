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
            $model->setTimestamp($value->getDate()->getTimestamp());
            $model->setHead("{$value->getHead()->getX()};{$value->getHead()->getY()};{$value->getHead()->getZ()}");
            $model->setShoulderLeft("{$value->getShoulderLeft()->getX()};{$value->getShoulderLeft()->getY()};{$value->getShoulderLeft()->getZ()}");
            $model->setShoulderCenter("{$value->getShoulderCenter()->getX()};{$value->getShoulderCenter()->getY()};{$value->getShoulderCenter()->getZ()}");
            $model->setShoulderRight("{$value->getShoulderRight()->getX()};{$value->getShoulderRight()->getY()};{$value->getShoulderRight()->getZ()}");
            $model->setElbowLeft("{$value->getElbowLeft()->getX()};{$value->getElbowLeft()->getY()};{$value->getElbowLeft()->getZ()}");
            $model->setElbowRight("{$value->getElbowRight()->getX()};{$value->getElbowRight()->getY()};{$value->getElbowRight()->getZ()}");
            $model->setHandLeft("{$value->getHandLeft()->getX()};{$value->getHandLeft()->getY()};{$value->getHandLeft()->getZ()}");
            $model->setHandRight("{$value->getHandRight()->getX()};{$value->getHandRight()->getY()};{$value->getHandRight()->getZ()}");
            $model->setCom("{$value->getCom()->getX()};{$value->getCom()->getY()};{$value->getCom()->getZ()}");
            $model->setSpine("{$value->getSpine()->getX()};{$value->getSpine()->getY()};{$value->getSpine()->getZ()}");
            $model->setHipLeft("{$value->getHipLeft()->getX()};{$value->getHipLeft()->getY()};{$value->getHipLeft()->getZ()}");
            $model->setHipRight("{$value->getHipRight()->getX()};{$value->getHipRight()->getY()};{$value->getHipRight()->getZ()}");
            $model->setKneeLeft("{$value->getKneeLeft()->getX()};{$value->getKneeLeft()->getY()};{$value->getKneeLeft()->getZ()}");
            $model->setKneeRight("{$value->getKneeRight()->getX()};{$value->getKneeRight()->getY()};{$value->getKneeRight()->getZ()}");
            $model->setFootLeft("{$value->getFootLeft()->getX()};{$value->getFootLeft()->getY()};{$value->getFootLeft()->getZ()}");
            $model->setFootRight("{$value->getFootRight()->getX()};{$value->getFootRight()->getY()};{$value->getFootRight()->getZ()}");
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
            $entity->setDate((new \DateTime())->setTimestamp($value->getTimestamp()));
            if (($coordinates = explode(';', $value->getHead())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setHead(
                    (new Coordinate())
                        ->setX($x)
                        ->setY($y)
                        ->setZ($z)
                );
            }
            if (($coordinates = explode(';', $value->getShoulderLeft())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setShoulderLeft(
                    (new Coordinate())
                        ->setX($x)
                        ->setY($y)
                        ->setZ($z)
                );
            }
            if (($coordinates = explode(';', $value->getShoulderCenter())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setShoulderCenter(
                    (new Coordinate())
                        ->setX($x)
                        ->setY($y)
                        ->setZ($z)
                );
            }
            if (($coordinates = explode(';', $value->getShoulderRight())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setShoulderRight(
                    (new Coordinate())
                        ->setX($x)
                        ->setY($y)
                        ->setZ($z)
                );
            }
            if (($coordinates = explode(';', $value->getElbowLeft())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setElbowLeft(
                    (new Coordinate())
                        ->setX($x)
                        ->setY($y)
                        ->setZ($z)
                );
            }
            if (($coordinates = explode(';', $value->getElbowRight())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setElbowRight(
                    (new Coordinate())
                        ->setX($x)
                        ->setY($y)
                        ->setZ($z)
                );
            }

            if (($coordinates = explode(';', $value->getHandLeft())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setHandLeft(
                    (new Coordinate())
                        ->setX($x)
                        ->setY($y)
                        ->setZ($z)
                );
            }

            if (($coordinates = explode(';', $value->getHandRight())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setHandRight(
                    (new Coordinate())
                        ->setX($x)
                        ->setY($y)
                        ->setZ($z)
                );
            }

            if (($coordinates = explode(';', $value->getCom())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setCom(
                    (new Coordinate())
                        ->setX($x)
                        ->setY($y)
                        ->setZ($z)
                );
            }

            if (($coordinates = explode(';', $value->getSpine())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setSpine(
                    (new Coordinate())
                        ->setX($x)
                        ->setY($y)
                        ->setZ($z)
                );
            }

            if (($coordinates = explode(';', $value->getHipLeft())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setHipLeft(
                    (new Coordinate())
                        ->setX($x)
                        ->setY($y)
                        ->setZ($z)
                );
            }

            if (($coordinates = explode(';', $value->getHipRight())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setHipRight(
                    (new Coordinate())
                        ->setX($x)
                        ->setY($y)
                        ->setZ($z)
                );
            }

            if (($coordinates = explode(';', $value->getKneeLeft())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setKneeLeft(
                    (new Coordinate())
                        ->setX($x)
                        ->setY($y)
                        ->setZ($z)
                );
            }

            if (($coordinates = explode(';', $value->getKneeRight())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setKneeRight(
                    (new Coordinate())
                        ->setX($x)
                        ->setY($y)
                        ->setZ($z)
                );
            }

            if (($coordinates = explode(';', $value->getFootLeft())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setFootLeft(
                    (new Coordinate())
                        ->setX($x)
                        ->setY($y)
                        ->setZ($z)
                );
            }

            if (($coordinates = explode(';', $value->getFootRight())) and count($coordinates) == 3) {
                list ($x, $y, $z) = $coordinates;
                $entity->setFootRight(
                    (new Coordinate())
                        ->setX($x)
                        ->setY($y)
                        ->setZ($z)
                );
            }
        }

        return $entity;
    }
}