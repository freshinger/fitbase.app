<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 18/02/15
 * Time: 11:13
 */
namespace Wellbeing\Bundle\ApiBundle\Tests\Form\DataTransformer;


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
use Wellbeing\Bundle\ApiBundle\Entity\UserState;
use Wellbeing\Bundle\ApiBundle\Form\DataTransformer\UserStateDataTransformer;

class UserStateDataTransformerTest extends \PHPUnit_Framework_TestCase
{
    protected function getUserState()
    {
        return (new UserState())
            ->setDate(new \DateTime('now'))
            ->setHead(
                (new UserCoordinateHead())
                    ->setX(1.1)
                    ->setY(1.2)
                    ->setZ(1.3)
            )
            ->setShoulderLeft(
                (new UserCoordinateShoulderLeft())
                    ->setX(2.1)
                    ->setY(2.2)
                    ->setZ(2.3)
            )
            ->setShoulderCenter(
                (new UserCoordinateShoulderCenter())
                    ->setX(3.1)
                    ->setY(3.2)
                    ->setZ(3.3)
            )
            ->setShoulderRight(
                (new UserCoordinateShoulderRight())
                    ->setX(4.1)
                    ->setY(4.2)
                    ->setZ(4.3)
            )
            ->setElbowLeft(
                (new UserCoordinateElbowLeft())
                    ->setX(5.1)
                    ->setY(5.2)
                    ->setZ(5.3)
            )
            ->setElbowRight(
                (new UserCoordinateElbowRight())
                    ->setX(6.1)
                    ->setY(6.3)
                    ->setZ(6.3)
            )
            ->setHandLeft(
                (new UserCoordinateHandLeft())
                    ->setX(7.1)
                    ->setY(7.2)
                    ->setZ(7.3)
            )
            ->setHandRight(
                (new UserCoordinateHandRight())
                    ->setX(8.1)
                    ->setY(8.2)
                    ->setZ(8.3)
            )
            ->setCom(
                (new UserCoordinateCom())
                    ->setX(9.1)
                    ->setY(9.2)
                    ->setZ(9.3)
            )
            ->setSpine(
                (new UserCoordinateSpine())
                    ->setX(10.1)
                    ->setY(10.2)
                    ->setZ(10.3)
            )
            ->setHipLeft(
                (new UserCoordinateHipLeft())
                    ->setX(13.1)
                    ->setY(13.2)
                    ->setZ(12.3)
            )
            ->setHipRight(
                (new UserCoordinateHipRight())
                    ->setX(14.1)
                    ->setY(14.2)
                    ->setZ(14.3)
            )
            ->setKneeLeft(
                (new UserCoordinateKneeLeft())
                    ->setX(15.1)
                    ->setY(15.2)
                    ->setZ(15.3)
            )
            ->setKneeRight(
                (new UserCoordinateKneeRight())
                    ->setX(16.1)
                    ->setY(16.2)
                    ->setZ(16.3)
            )
            ->setFootLeft(
                (new UserCoordinateFootLeft())
                    ->setX(17.1)
                    ->setY(17.2)
                    ->setZ(17.3)
            )
            ->setFootRight(
                (new UserCoordinateFootRight())
                    ->setX(18.1)
                    ->setY(18.2)
                    ->setZ(18.3)
            );
    }

    protected function getUserStateModel()
    {
        return (new \Wellbeing\Bundle\ApiBundle\Model\UserState())
            ->setTimestamp((new \DateTime('now'))->getTimestamp())
            ->setHead("1.1;1.2;1.3")
            ->setShoulderLeft("2.1;2.2;2.3")
            ->setShoulderCenter("3.1;3.2;3.3")
            ->setShoulderRight("4.1;4.2;4.3")
            ->setElbowLeft("5.1;5.2;5.3")
            ->setElbowRight("6.1;6.2;6.3")
            ->setHandLeft("7.1;7.2;7.3")
            ->setHandRight("8.1;8.2;8.3")
            ->setCom("9.1;9.2;9.3")
            ->setSpine("10.1;10.2;10.3")
            ->setHipLeft("11.1;11.2;11.3")
            ->setHipRight("12.1;12.2;12.3")
            ->setKneeLeft("13.1;13.2;13.3")
            ->setKneeRight("14.1;14.2;14.3")
            ->setFootLeft("15.1;15.2;15.3")
            ->setFootRight("16.1;16.2;16.3");
    }


    public function testTransformerShouldReturnModel()
    {
        $transformer = new UserStateDataTransformer();


        $this->assertTrue($transformer->transform($this->getUserState()) instanceof \Wellbeing\Bundle\ApiBundle\Model\UserState);
    }

    public function testTransformerShouldChangeDatetimeToInt()
    {
        $transformer = new UserStateDataTransformer();

        $datetime = new \DateTime('now');

        $state = $this->getUserState();
        $state->setDate($datetime);

        $model = $transformer->transform($state);

        $this->assertEquals($model->getTimestamp(), $datetime->getTimestamp());
    }

    public function testTransformerShouldChangeHeadToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserState();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getHead(), "{$state->getHead()->getX()};{$state->getHead()->getY()};{$state->getHead()->getZ()}");
    }

    public function testTransformerShouldChangeShoulderLeftToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserState();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getShoulderLeft(), "{$state->getShoulderLeft()->getX()};{$state->getShoulderLeft()->getY()};{$state->getShoulderLeft()->getZ()}");
    }

    public function testTransformerShouldChangeShoulderCenterToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserState();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getShoulderCenter(), "{$state->getShoulderCenter()->getX()};{$state->getShoulderCenter()->getY()};{$state->getShoulderCenter()->getZ()}");
    }

    public function testTransformerShouldChangeShoulderRightToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserState();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getShoulderRight(), "{$state->getShoulderRight()->getX()};{$state->getShoulderRight()->getY()};{$state->getShoulderRight()->getZ()}");
    }

    public function testTransformerShouldChangeElbowLeftToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserState();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getElbowLeft(), "{$state->getElbowLeft()->getX()};{$state->getElbowLeft()->getY()};{$state->getElbowLeft()->getZ()}");
    }

    public function testTransformerShouldChangeElbowRightToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserState();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getElbowRight(), "{$state->getElbowRight()->getX()};{$state->getElbowRight()->getY()};{$state->getElbowRight()->getZ()}");
    }

    public function testTransformerShouldChangeHandLeftToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserState();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getHandLeft(), "{$state->getHandLeft()->getX()};{$state->getHandLeft()->getY()};{$state->getHandLeft()->getZ()}");
    }

    public function testTransformerShouldChangeHandRightToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserState();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getHandRight(), "{$state->getHandRight()->getX()};{$state->getHandRight()->getY()};{$state->getHandRight()->getZ()}");
    }

    public function testTransformerShouldChangeComToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserState();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getCom(), "{$state->getCom()->getX()};{$state->getCom()->getY()};{$state->getCom()->getZ()}");
    }

    public function testTransformerShouldChangeSpineToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserState();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getSpine(), "{$state->getSpine()->getX()};{$state->getSpine()->getY()};{$state->getSpine()->getZ()}");
    }

    public function testTransformerShouldChangeHipLeftToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserState();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getHipLeft(), "{$state->getHipLeft()->getX()};{$state->getHipLeft()->getY()};{$state->getHipLeft()->getZ()}");
    }

    public function testTransformerShouldChangeHipRightToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserState();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getHipRight(), "{$state->getHipRight()->getX()};{$state->getHipRight()->getY()};{$state->getHipRight()->getZ()}");
    }

    public function testTransformerShouldChangeKneeLeftToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserState();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getKneeLeft(), "{$state->getKneeLeft()->getX()};{$state->getKneeLeft()->getY()};{$state->getKneeLeft()->getZ()}");
    }

    public function testTransformerShouldChangeKneeRightToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserState();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getKneeRight(), "{$state->getKneeRight()->getX()};{$state->getKneeRight()->getY()};{$state->getKneeRight()->getZ()}");
    }

    public function testTransformerShouldChangeFootLeftToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserState();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getFootLeft(), "{$state->getFootLeft()->getX()};{$state->getFootLeft()->getY()};{$state->getFootLeft()->getZ()}");
    }

    public function testTransformerShouldChangeFootRightToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserState();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getFootRight(), "{$state->getFootRight()->getX()};{$state->getFootRight()->getY()};{$state->getFootRight()->getZ()}");
    }

    public function testReverseTransformerShouldReturnCorrectObject()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserState();

        $model = $transformer->reverseTransform($state);

        $this->assertTrue($model instanceof UserState);
    }

    public function testReverseTransformerShouldChangeTimestampToDateTime()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserStateModel();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals($entity->getDate()->getTimestamp(), $model->getTimestamp());
    }

    public function testReverseTransformerShouldChangeHeadToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserStateModel();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getHead()->getX()};{$entity->getHead()->getY()};{$entity->getHead()->getZ()}", $model->getHead());
    }

    public function testReverseTransformerShouldChangeShoulderLeftToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserStateModel();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getShoulderLeft()->getX()};{$entity->getShoulderLeft()->getY()};{$entity->getShoulderLeft()->getZ()}", $model->getShoulderLeft());
    }

    public function testReverseTransformerShouldChangeShoulderCenterToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserStateModel();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getShoulderCenter()->getX()};{$entity->getShoulderCenter()->getY()};{$entity->getShoulderCenter()->getZ()}", $model->getShoulderCenter());
    }

    public function testReverseTransformerShouldChangeShoulderRightToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserStateModel();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getShoulderRight()->getX()};{$entity->getShoulderRight()->getY()};{$entity->getShoulderRight()->getZ()}", $model->getShoulderRight());
    }

    public function testReverseTransformerShouldChangeElbowLeftToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserStateModel();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getElbowLeft()->getX()};{$entity->getElbowLeft()->getY()};{$entity->getElbowLeft()->getZ()}", $model->getElbowLeft());
    }

    public function testReverseTransformerShouldChangeElbowRightToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserStateModel();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getElbowRight()->getX()};{$entity->getElbowRight()->getY()};{$entity->getElbowRight()->getZ()}", $model->getElbowRight());
    }


    public function testReverseTransformerShouldChangeHandLeftToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserStateModel();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getHandLeft()->getX()};{$entity->getHandLeft()->getY()};{$entity->getHandLeft()->getZ()}", $model->getHandLeft());
    }

    public function testReverseTransformerShouldChangeHandRightToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserStateModel();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getHandRight()->getX()};{$entity->getHandRight()->getY()};{$entity->getHandRight()->getZ()}", $model->getHandRight());
    }

    public function testReverseTransformerShouldChangeComToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserStateModel();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getCom()->getX()};{$entity->getCom()->getY()};{$entity->getCom()->getZ()}", $model->getCom());
    }

    public function testReverseTransformerShouldChangeSpineToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserStateModel();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getSpine()->getX()};{$entity->getSpine()->getY()};{$entity->getSpine()->getZ()}", $model->getSpine());
    }

    public function testReverseTransformerShouldChangeHipLeftToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserStateModel();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getHipLeft()->getX()};{$entity->getHipLeft()->getY()};{$entity->getHipLeft()->getZ()}", $model->getHipLeft());
    }

    public function testReverseTransformerShouldChangeHipRightToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserStateModel();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getHipRight()->getX()};{$entity->getHipRight()->getY()};{$entity->getHipRight()->getZ()}", $model->getHipRight());
    }

    public function testReverseTransformerShouldChangeKneeLeftToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserStateModel();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getKneeLeft()->getX()};{$entity->getKneeLeft()->getY()};{$entity->getKneeLeft()->getZ()}", $model->getKneeLeft());
    }

    public function testReverseTransformerShouldChangeKneeRightToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserStateModel();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getKneeRight()->getX()};{$entity->getKneeRight()->getY()};{$entity->getKneeRight()->getZ()}", $model->getKneeRight());
    }

    public function testReverseTransformerShouldChangeFootLeftToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserStateModel();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getFootLeft()->getX()};{$entity->getFootLeft()->getY()};{$entity->getFootLeft()->getZ()}", $model->getFootLeft());
    }

    public function testReverseTransformerShouldChangeFootRightToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserStateModel();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getFootRight()->getX()};{$entity->getFootRight()->getY()};{$entity->getFootRight()->getZ()}", $model->getFootRight());
    }
}