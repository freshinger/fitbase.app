<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 18/02/15
 * Time: 11:13
 */
namespace Wellbeing\Bundle\ErgonomicsBundle\Tests\Form\DataTransformer;

use Fitbase\Bundle\FitbaseBundle\Tests\FitbaseTestAbstract;
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
use Wellbeing\Bundle\ErgonomicsBundle\Form\DataTransformer\UserStateDataTransformer;

class UserStateDataTransformerTest extends FitbaseTestAbstract
{
    /**
     * Get user state object predefined for
     * ergonomics module
     *
     * @return $this
     */
    protected function getUserState()
    {
        return (new \Wellbeing\Bundle\ApiBundle\Model\UserState())
            ->setAuthKey('somestring')
            ->setTimestamp(time())
            ->setTicketType('T1')
            ->setHead('0.23;2.0;1.213')
            ->setNeck('0.23;2.0;1.213')
            ->setShoulderCenter('0.53;1.12;0.713')
            ->setShoulderLeft('1.53;0.712;1.113')
            ->setShoulderRight('1.23;2.12;0.213')
            ->setElbowLeft('1.23;2.12;0.213')
            ->setElbowRight('1.23;2.12;0.213')
            ->setHandLeft('1.23;2.12;0.213')
            ->setHandRight('1.23;2.12;0.213')
            ->setSpineMid('1.23;2.12;0.213')
            ->setSpineBase('1.23;2.12;0.213')
            ->setSpineShoulder('1.23;2.12;0.213')
            ->setLeanAmount('12;20')
            ->setHeadRotation('1.23;2.12;0.213');
    }

    /**
     * UserStateErgonomics object fo current test
     *
     * @return UserStateErgonomics
     */
    public function getUserStateErgonomics()
    {
        return (new UserStateErgonomics())
            ->setDate((new \DateTime('now'))->getTimestamp())
            ->setHead(new UserStateErgonomicsHead(1, 1, 1))
            ->setNeck(new UserStateErgonomicsNeck(1, 1, 1))
            ->setShoulderCenter(new UserStateErgonomicsShoulderCenter(1, 1, 1))
            ->setShoulderLeft(new UserStateErgonomicsShoulderLeft(1, 1, 1))
            ->setShoulderRight(new UserStateErgonomicsShoulderRight(1, 1, 1))
            ->setElbowLeft(new UserStateErgonomicsElbowLeft(1, 1, 1))
            ->setElbowRight(new UserStateErgonomicsElbowRight(1, 1, 1))
            ->setHandLeft(new UserStateErgonomicsHandLeft(1, 1, 1))
            ->setHandRight(new UserStateErgonomicsHandRight(1, 1, 1))
            ->setSpineMid(new UserStateErgonomicsSpineMid(1, 1, 1))
            ->setSpineBase(new UserStateErgonomicsSpineBase(1, 1, 1))
            ->setSpineShoulder(new UserStateErgonomicsSpineShoulder(1, 1, 1))
            ->setLeanAmount(new UserStateErgonomicsLeanAmount(1, 1))
            ->setHeadRotation(new UserStateErgonomicsHeadRotation(1, 1, 1));
    }

    public function testReverseTransformShouldReturnUserStateErgonomics()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

//        $std = new \stdClass();
//        $std->user_state = $model;
//
//        print_r(json_encode($std));

        $entity = $transformer->reverseTransform($model);

        $this->assertTrue($entity instanceof UserStateErgonomics);
    }

    public function testTransformerShouldReturnModel()
    {
        $transformer = new UserStateDataTransformer();

        $this->assertTrue($transformer->transform($this->getUserStateErgonomics()) instanceof \Wellbeing\Bundle\ApiBundle\Model\UserState);
    }

    public function testTransformerShouldChangeDatetimeToInt()
    {
        $transformer = new UserStateDataTransformer();

        $datetime = new \DateTime('now');

        $state = $this->getUserStateErgonomics();
        $state->setDate($datetime);

        $model = $transformer->transform($state);

        $this->assertEquals($model->getTimestamp(), $datetime->getTimestamp());
    }

    public function testTransformerShouldChangeHeadToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateErgonomics();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getHead(), "{$state->getHead()->getX()};{$state->getHead()->getY()};{$state->getHead()->getZ()}");
    }

    public function testTransformerShouldChangeNeckToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateErgonomics();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getNeck(), "{$state->getNeck()->getX()};{$state->getNeck()->getY()};{$state->getNeck()->getZ()}");
    }

    public function testTransformerShouldChangeShoulderLeftToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateErgonomics();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getShoulderLeft(), "{$state->getShoulderLeft()->getX()};{$state->getShoulderLeft()->getY()};{$state->getShoulderLeft()->getZ()}");
    }

    public function testTransformerShouldChangeShoulderCenterToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateErgonomics();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getShoulderCenter(), "{$state->getShoulderCenter()->getX()};{$state->getShoulderCenter()->getY()};{$state->getShoulderCenter()->getZ()}");
    }

    public function testTransformerShouldChangeShoulderRightToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateErgonomics();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getShoulderRight(), "{$state->getShoulderRight()->getX()};{$state->getShoulderRight()->getY()};{$state->getShoulderRight()->getZ()}");
    }

    public function testTransformerShouldChangeElbowLeftToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateErgonomics();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getElbowLeft(), "{$state->getElbowLeft()->getX()};{$state->getElbowLeft()->getY()};{$state->getElbowLeft()->getZ()}");
    }

    public function testTransformerShouldChangeElbowRightToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateErgonomics();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getElbowRight(), "{$state->getElbowRight()->getX()};{$state->getElbowRight()->getY()};{$state->getElbowRight()->getZ()}");
    }

    public function testTransformerShouldChangeHandLeftToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateErgonomics();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getHandLeft(), "{$state->getHandLeft()->getX()};{$state->getHandLeft()->getY()};{$state->getHandLeft()->getZ()}");
    }

    public function testTransformerShouldChangeHandRightToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateErgonomics();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getHandRight(), "{$state->getHandRight()->getX()};{$state->getHandRight()->getY()};{$state->getHandRight()->getZ()}");
    }

    public function testTransformerShouldChangeSpineToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateErgonomics();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getSpineMid(), "{$state->getSpineMid()->getX()};{$state->getSpineMid()->getY()};{$state->getSpineMid()->getZ()}");
    }

    public function testTransformerShouldChangeSpineBaseToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateErgonomics();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getSpineBase(), "{$state->getSpineBase()->getX()};{$state->getSpineBase()->getY()};{$state->getSpineBase()->getZ()}");
    }

    public function testTransformerShouldChangeSpineShoulderToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateErgonomics();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getSpineShoulder(), "{$state->getSpineShoulder()->getX()};{$state->getSpineShoulder()->getY()};{$state->getSpineShoulder()->getZ()}");
    }

    public function testTransformerShouldChangeLeanAmountToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateErgonomics();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getLeanAmount(), "{$state->getLeanAmount()->getX()};{$state->getLeanAmount()->getY()}");
    }

    public function testTransformerShouldChangeHeadRotationToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateErgonomics();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getHeadRotation(), "{$state->getHeadRotation()->getX()};{$state->getHeadRotation()->getY()};{$state->getHeadRotation()->getZ()}");
    }


    public function testReverseTransformerShouldReturnCorrectObject()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserState();

        $model = $transformer->reverseTransform($state);

        $this->assertTrue($model instanceof UserStateErgonomics);
    }

    public function testReverseTransformerShouldChangeTimestampToDateTime()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals($entity->getDate()->getTimestamp(), $model->getTimestamp());
    }

    public function testReverseTransformerShouldChangeHeadToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getHead()->getX()};{$entity->getHead()->getY()};{$entity->getHead()->getZ()}", $model->getHead());
    }

    public function testReverseTransformerShouldChangeShoulderLeftToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getShoulderLeft()->getX()};{$entity->getShoulderLeft()->getY()};{$entity->getShoulderLeft()->getZ()}", $model->getShoulderLeft());
    }

    public function testReverseTransformerShouldChangeShoulderCenterToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getShoulderCenter()->getX()};{$entity->getShoulderCenter()->getY()};{$entity->getShoulderCenter()->getZ()}", $model->getShoulderCenter());
    }

    public function testReverseTransformerShouldChangeShoulderRightToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getShoulderRight()->getX()};{$entity->getShoulderRight()->getY()};{$entity->getShoulderRight()->getZ()}", $model->getShoulderRight());
    }

    public function testReverseTransformerShouldChangeElbowLeftToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getElbowLeft()->getX()};{$entity->getElbowLeft()->getY()};{$entity->getElbowLeft()->getZ()}", $model->getElbowLeft());
    }

    public function testReverseTransformerShouldChangeElbowRightToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getElbowRight()->getX()};{$entity->getElbowRight()->getY()};{$entity->getElbowRight()->getZ()}", $model->getElbowRight());
    }


    public function testReverseTransformerShouldChangeHandLeftToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getHandLeft()->getX()};{$entity->getHandLeft()->getY()};{$entity->getHandLeft()->getZ()}", $model->getHandLeft());
    }

    public function testReverseTransformerShouldChangeHandRightToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getHandRight()->getX()};{$entity->getHandRight()->getY()};{$entity->getHandRight()->getZ()}", $model->getHandRight());
    }

    public function testReverseTransformerShouldChangeSpineToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getSpineMid()->getX()};{$entity->getSpineMid()->getY()};{$entity->getSpineMid()->getZ()}", $model->getSpineMid());
    }

    public function testReverseTransformerShouldChangeSpineBaseToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getSpineBase()->getX()};{$entity->getSpineBase()->getY()};{$entity->getSpineBase()->getZ()}", $model->getSpineBase());
    }

    public function testReverseTransformerShouldChangeSpineShoulderToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getSpineShoulder()->getX()};{$entity->getSpineShoulder()->getY()};{$entity->getSpineShoulder()->getZ()}", $model->getSpineShoulder());
    }

    public function testReverseTransformerShouldChangeLeanAmountToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getLeanAmount()->getX()};{$entity->getLeanAmount()->getY()}", $model->getLeanAmount());
    }

    public function testReverseTransformerShouldChangeHipRightToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getHeadRotation()->getX()};{$entity->getHeadRotation()->getY()};{$entity->getHeadRotation()->getZ()}", $model->getHeadRotation());
    }
}