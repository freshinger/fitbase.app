<?php
namespace Wellbeing\Bundle\ExerciseBundle\Tests\Form\DataTransformer;

use Wellbeing\Bundle\ApiBundle\Model\UserStateErgonomics;
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
use Wellbeing\Bundle\ExerciseBundle\Form\DataTransformer\UserStateDataTransformer;

class UserStateDataTransformerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Get user state object predefined for
     * exercise module
     *
     * @return $this
     */
    protected function getUserState()
    {
        return (new \Wellbeing\Bundle\ApiBundle\Model\UserState())
            ->setAuthKey('somestring')
            ->setTimestamp(time())
            ->setTicketType('T3')
            ->setHead('1.23;2.12;0.213')
            ->setNeck('1.23;2.12;0.213')
            ->setShoulderCenter('1.23;2.12;0.213')
            ->setShoulderLeft('1.23;2.12;0.213')
            ->setShoulderRight('1.23;2.12;0.213')
            ->setElbowLeft('1.23;2.12;0.213')
            ->setElbowRight('1.23;2.12;0.213')
            ->setWristLeft('1.23;2.12;0.213')
            ->setWristRight('1.23;2.12;0.213')
            ->setHandLeft('1.23;2.12;0.213')
            ->setHandRight('1.23;2.12;0.213')
            ->setThumbLeft('1.23;2.12;0.213')
            ->setThumbRight('1.23;2.12;0.213')
            ->setHandTipLeft('1.23;2.12;0.213')
            ->setHandTipRight('1.23;2.12;0.213')
            ->setSpineMid('1.23;2.12;0.213')
            ->setSpineBase('1.23;2.12;0.213')
            ->setHipLeft('1.23;2.12;0.213')
            ->setHipRight('1.23;2.12;0.213')
            ->setKneeLeft('1.23;2.12;0.213')
            ->setKneeRight('1.23;2.12;0.213')
            ->setAnkleLeft('1.23;2.12;0.213')
            ->setAnkleRight('1.23;2.12;0.213')
            ->setFootLeft('1.23;2.12;0.213')
            ->setFootRight('1.23;2.12;0.213')
            ->setLeftHandState(rand(-1, 2))
            ->setRightHandState(rand(-1, 2))
            ->setLeanAmount('15;35')
            ->setHeadRotation('1.23;2.12;0.213');
    }

    protected function getUserStateExercise()
    {
        return (new UserStateExercise())
            ->setHead(new UserStateExerciseHead(1, 1, 1))
            ->setNeck(new UserStateExerciseNeck(1, 1, 1))
            ->setShoulderCenter(new UserStateExerciseShoulderCenter(1, 1, 1))
            ->setShoulderLeft(new UserStateExerciseShoulderLeft(1, 1, 1))
            ->setShoulderRight(new UserStateExerciseShoulderRight(1, 1, 1))
            ->setElbowLeft(new UserStateExerciseElbowLeft(1, 1, 1))
            ->setElbowRight(new UserStateExerciseElbowRight(1, 1, 1))
            ->setWristLeft(new UserStateExerciseWristLeft(1, 1, 1))
            ->setWristRight(new UserStateExerciseWristRight(1, 1, 1))
            ->setHandLeft(new UserStateExerciseHandLeft(1, 1, 1))
            ->setHandRight(new UserStateExerciseHandRight(1, 1, 1))
            ->setThumbLeft(new UserStateExerciseThumbLeft(1, 1, 1))
            ->setThumbRight(new UserStateExerciseThumbRight(1, 1, 1))
            ->setHandTipLeft(new UserStateExerciseHandTipLeft(1, 1, 1))
            ->setHandTipRight(new UserStateExerciseHandTipRight(1, 1, 1))
            ->setSpineMid(new UserStateExerciseSpineMid(1, 1, 1))
            ->setSpineBase(new UserStateExerciseSpineBase(1, 1, 1))
            ->setHipLeft(new UserStateExerciseHipLeft(1, 1, 1))
            ->setHipRight(new UserStateExerciseHipRight(1, 1, 1))
            ->setKneeLeft(new UserStateExerciseKneeLeft(1, 1, 1))
            ->setKneeRight(new UserStateExerciseKneeRight(1, 1, 1))
            ->setAnkleLeft(new UserStateExerciseAnkleLeft(1, 1, 1))
            ->setAnkleRight(new UserStateExerciseAnkleRight(1, 1, 1))
            ->setFootLeft(new UserStateExerciseFootLeft(1, 1, 1))
            ->setFootRight(new UserStateExerciseFootRight(1, 1, 1))
            ->setLeftHandState(new UserStateExerciseLeftHandState(1))
            ->setRightHandState(new UserStateExerciseRightHandState(1))
            ->setLeanAmount(new UserStateExerciseLeanAmount(1, 1))
            ->setHeadRotation(new UserStateExerciseHeadRotation(1, 1, 1));
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

        $this->assertTrue($entity instanceof UserStateExercise);
    }

    public function testTransformerShouldReturnModel()
    {
        $transformer = new UserStateDataTransformer();


        $this->assertTrue($transformer->transform($this->getUserStateExercise()) instanceof \Wellbeing\Bundle\ApiBundle\Model\UserState);
    }


    public function testTransformerShouldChangeDatetimeToInt()
    {
        $transformer = new UserStateDataTransformer();

        $datetime = new \DateTime('now');

        $state = $this->getUserStateExercise();
        $state->setDate($datetime);

        $model = $transformer->transform($state);

        $this->assertEquals($model->getTimestamp(), $datetime->getTimestamp());
    }

    public function testTransformerShouldChangeHeadToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateExercise();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getHead(), "{$state->getHead()->getX()};{$state->getHead()->getY()};{$state->getHead()->getZ()}");
    }

    public function testTransformerShouldChangeNeckToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateExercise();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getNeck(), "{$state->getNeck()->getX()};{$state->getNeck()->getY()};{$state->getNeck()->getZ()}");
    }

    public function testTransformerShouldChangeShoulderLeftToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateExercise();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getShoulderLeft(), "{$state->getShoulderLeft()->getX()};{$state->getShoulderLeft()->getY()};{$state->getShoulderLeft()->getZ()}");
    }

    public function testTransformerShouldChangeShoulderCenterToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateExercise();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getShoulderCenter(), "{$state->getShoulderCenter()->getX()};{$state->getShoulderCenter()->getY()};{$state->getShoulderCenter()->getZ()}");
    }

    public function testTransformerShouldChangeShoulderRightToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateExercise();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getShoulderRight(), "{$state->getShoulderRight()->getX()};{$state->getShoulderRight()->getY()};{$state->getShoulderRight()->getZ()}");
    }

    public function testTransformerShouldChangeElbowLeftToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateExercise();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getElbowLeft(), "{$state->getElbowLeft()->getX()};{$state->getElbowLeft()->getY()};{$state->getElbowLeft()->getZ()}");
    }

    public function testTransformerShouldChangeElbowRightToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateExercise();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getElbowRight(), "{$state->getElbowRight()->getX()};{$state->getElbowRight()->getY()};{$state->getElbowRight()->getZ()}");
    }

    public function testTransformerShouldChangeWristLeftToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateExercise();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getWristLeft(), "{$state->getWristLeft()->getX()};{$state->getWristLeft()->getY()};{$state->getWristLeft()->getZ()}");
    }

    public function testTransformerShouldChangeWristRightToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateExercise();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getWristRight(), "{$state->getWristRight()->getX()};{$state->getWristRight()->getY()};{$state->getWristRight()->getZ()}");
    }

    public function testTransformerShouldChangeHandLeftToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateExercise();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getHandLeft(), "{$state->getHandLeft()->getX()};{$state->getHandLeft()->getY()};{$state->getHandLeft()->getZ()}");
    }

    public function testTransformerShouldChangeHandRightToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateExercise();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getHandRight(), "{$state->getHandRight()->getX()};{$state->getHandRight()->getY()};{$state->getHandRight()->getZ()}");
    }

    public function testTransformerShouldChangeThumbLeftToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateExercise();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getThumbLeft(), "{$state->getThumbLeft()->getX()};{$state->getThumbLeft()->getY()};{$state->getThumbLeft()->getZ()}");
    }

    public function testTransformerShouldChangeThumbRightToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateExercise();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getThumbRight(), "{$state->getThumbRight()->getX()};{$state->getThumbRight()->getY()};{$state->getThumbRight()->getZ()}");
    }

    public function testTransformerShouldChangeHandTipLeftToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateExercise();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getHandTipLeft(), "{$state->getHandTipLeft()->getX()};{$state->getHandTipLeft()->getY()};{$state->getHandTipLeft()->getZ()}");
    }

    public function testTransformerShouldChangeHandTipRightToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateExercise();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getHandTipRight(), "{$state->getHandTipRight()->getX()};{$state->getHandTipRight()->getY()};{$state->getHandTipRight()->getZ()}");
    }

    public function testTransformerShouldChangeSpineMidToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateExercise();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getSpineMid(), "{$state->getSpineMid()->getX()};{$state->getSpineMid()->getY()};{$state->getSpineMid()->getZ()}");
    }

    public function testTransformerShouldChangeSpineBaseToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateExercise();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getSpineBase(), "{$state->getSpineBase()->getX()};{$state->getSpineBase()->getY()};{$state->getSpineBase()->getZ()}");
    }

    public function testTransformerShouldChangeHipLeftToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateExercise();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getHipLeft(), "{$state->getHipLeft()->getX()};{$state->getHipLeft()->getY()};{$state->getHipLeft()->getZ()}");
    }

    public function testTransformerShouldChangeHipRightToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateExercise();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getHipRight(), "{$state->getHipRight()->getX()};{$state->getHipRight()->getY()};{$state->getHipRight()->getZ()}");
    }

    public function testTransformerShouldChangeKneeLeftToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateExercise();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getKneeLeft(), "{$state->getKneeLeft()->getX()};{$state->getKneeLeft()->getY()};{$state->getKneeLeft()->getZ()}");
    }

    public function testTransformerShouldChangeKneeRightToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateExercise();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getKneeRight(), "{$state->getKneeRight()->getX()};{$state->getKneeRight()->getY()};{$state->getKneeRight()->getZ()}");
    }

    public function testTransformerShouldChangeAnkleLeftToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateExercise();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getAnkleLeft(), "{$state->getAnkleLeft()->getX()};{$state->getAnkleLeft()->getY()};{$state->getAnkleLeft()->getZ()}");
    }

    public function testTransformerShouldChangeAnkleRightToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateExercise();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getAnkleRight(), "{$state->getAnkleRight()->getX()};{$state->getAnkleRight()->getY()};{$state->getAnkleRight()->getZ()}");
    }

    public function testTransformerShouldChangeFootLeftToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateExercise();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getFootLeft(), "{$state->getFootLeft()->getX()};{$state->getFootLeft()->getY()};{$state->getFootLeft()->getZ()}");
    }

    public function testTransformerShouldChangeFootRightToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateExercise();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getFootRight(), "{$state->getFootRight()->getX()};{$state->getFootRight()->getY()};{$state->getFootRight()->getZ()}");
    }

    public function testTransformerShouldChangeLeftHandStateToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateExercise();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getLeftHandState(), $state->getLeftHandState()->getValue());
    }

    public function testTransformerShouldChangeRightHandStateToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateExercise();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getRightHandState(), $state->getRightHandState()->getValue());
    }

    public function testTransformerShouldChangeLeanAmountToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateExercise();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getLeanAmount(), "{$state->getLeanAmount()->getX()};{$state->getLeanAmount()->getY()}");
    }

    public function testTransformerShouldChangeHeadRotationToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateExercise();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getHeadRotation(), "{$state->getHeadRotation()->getX()};{$state->getHeadRotation()->getY()};{$state->getHeadRotation()->getZ()}");
    }

    public function testReverseTransformerShouldReturnCorrectObject()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserState();

        $model = $transformer->reverseTransform($state);

        $this->assertTrue($model instanceof UserStateExercise);
    }

    public function testReverseTransformerShouldChangeTimestampToDateTime()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals($entity->getDate()->getTimestamp(), $model->getTimestamp());
    }

    public function testReverseTransformerShouldChangeHeadToObject()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getHead()->getX()};{$entity->getHead()->getY()};{$entity->getHead()->getZ()}", $model->getHead());
    }

    public function testReverseTransformerShouldChangeNeckToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getNeck()->getX()};{$entity->getNeck()->getY()};{$entity->getNeck()->getZ()}", $model->getNeck());
    }

    public function testReverseTransformerShouldChangeShoulderCenterToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getShoulderCenter()->getX()};{$entity->getShoulderCenter()->getY()};{$entity->getShoulderCenter()->getZ()}", $model->getShoulderCenter());
    }

    public function testReverseTransformerShouldChangeShoulderLeftToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getShoulderLeft()->getX()};{$entity->getShoulderLeft()->getY()};{$entity->getShoulderLeft()->getZ()}", $model->getShoulderLeft());
    }

    public function testReverseTransformerShouldChangeShoulderRightToObject()
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

    public function testReverseTransformerShouldChangeWristLeftToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getWristLeft()->getX()};{$entity->getWristLeft()->getY()};{$entity->getWristLeft()->getZ()}", $model->getWristLeft());
    }

    public function testReverseTransformerShouldChangeWristRightToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getWristRight()->getX()};{$entity->getWristRight()->getY()};{$entity->getWristRight()->getZ()}", $model->getWristRight());
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

    public function testReverseTransformerShouldChangeThumbLeftToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getThumbLeft()->getX()};{$entity->getThumbLeft()->getY()};{$entity->getThumbLeft()->getZ()}", $model->getThumbLeft());
    }

    public function testReverseTransformerShouldChangeThumbRightToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getThumbRight()->getX()};{$entity->getThumbRight()->getY()};{$entity->getThumbRight()->getZ()}", $model->getThumbRight());
    }


    public function testReverseTransformerShouldChangeHandTipLeftToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getHandTipLeft()->getX()};{$entity->getHandTipLeft()->getY()};{$entity->getHandTipLeft()->getZ()}", $model->getHandTipLeft());
    }

    public function testReverseTransformerShouldChangeHandTipRightToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getHandTipRight()->getX()};{$entity->getHandTipRight()->getY()};{$entity->getHandTipRight()->getZ()}", $model->getHandTipRight());
    }

    public function testReverseTransformerShouldChangeSpineMidToCoordinate()
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

    public function testReverseTransformerShouldChangeHipLeftToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getHipLeft()->getX()};{$entity->getHipLeft()->getY()};{$entity->getHipLeft()->getZ()}", $model->getHipLeft());
    }

    public function testReverseTransformerShouldChangeHipRightToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getHipRight()->getX()};{$entity->getHipRight()->getY()};{$entity->getHipRight()->getZ()}", $model->getHipRight());
    }

    public function testReverseTransformerShouldChangeKneeLeftToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getKneeLeft()->getX()};{$entity->getKneeLeft()->getY()};{$entity->getKneeLeft()->getZ()}", $model->getKneeLeft());
    }

    public function testReverseTransformerShouldChangeKneeRightToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getKneeRight()->getX()};{$entity->getKneeRight()->getY()};{$entity->getKneeRight()->getZ()}", $model->getKneeRight());
    }


    public function testReverseTransformerShouldChangeAnkleLeftToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getAnkleLeft()->getX()};{$entity->getAnkleLeft()->getY()};{$entity->getAnkleLeft()->getZ()}", $model->getAnkleLeft());
    }

    public function testReverseTransformerShouldChangeAnkleRightToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getAnkleRight()->getX()};{$entity->getAnkleRight()->getY()};{$entity->getAnkleRight()->getZ()}", $model->getAnkleRight());
    }

    public function testReverseTransformerShouldChangeFootLeftToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getFootLeft()->getX()};{$entity->getFootLeft()->getY()};{$entity->getFootLeft()->getZ()}", $model->getFootLeft());
    }

    public function testReverseTransformerShouldChangeFootRightToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getFootRight()->getX()};{$entity->getFootRight()->getY()};{$entity->getFootRight()->getZ()}", $model->getFootRight());
    }

    public function testReverseTransformerShouldChangeLeftHandStateToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals($entity->getLeftHandState()->getValue(), $model->getLeftHandState());
    }

    public function testReverseTransformerShouldChangeRightHandStateToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals($entity->getRightHandState()->getValue(), $model->getRightHandState());
    }

    public function testReverseTransformerShouldChangeLeanAmountToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getLeanAmount()->getX()};{$entity->getLeanAmount()->getY()}", $model->getLeanAmount());
    }

    public function testReverseTransformerShouldChangeHeadRotationToCoordinate()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals("{$entity->getHeadRotation()->getX()};{$entity->getHeadRotation()->getY()};{$entity->getHeadRotation()->getZ()}", $model->getHeadRotation());
    }
}