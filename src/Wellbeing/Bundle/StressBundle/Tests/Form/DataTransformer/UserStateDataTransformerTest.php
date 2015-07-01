<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 18/02/15
 * Time: 11:13
 */
namespace Wellbeing\Bundle\StressBundle\Tests\Form\DataTransformer;


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
use Wellbeing\Bundle\StressBundle\Form\DataTransformer\UserStateDataTransformer;

class UserStateDataTransformerTest extends \PHPUnit_Framework_TestCase
{

    protected function getUserStateStress()
    {
        return (new UserStateStress())
            ->setDate(new \DateTime())
            ->setJawOpen(new UserStateStressJawOpen(1))
            ->setLipPucker(new UserStateStressLipPucker(1))
            ->setJawSlideRight(new UserStateStressJawSlideRight(1))
            ->setLipStretcherLeft(new UserStateStressLipStretcherLeft(1))
            ->setLipStretcherRight(new UserStateStressLipStretcherRight(1))
            ->setLipCornerPullerLeft(new UserStateStressLipCornerPullerLeft(1))
            ->setLipCornerPullerRight(new UserStateStressLipCornerPullerRight(1))
            ->setLipCornerDepressorLeft(new UserStateStressLipCornerDepressorLeft(1))
            ->setLipCornerDepressorRight(new UserStateStressLipCornerDepressorRight(1))
            ->setLeftCheekPuff(new UserStateStressLeftCheekPuff(1))
            ->setRightCheekPuff(new UserStateStressRightCheekPuff(1))
            ->setLeftEyeClosed(new UserStateStressLeftEyeClosed(1))
            ->setRightEyeClosed(new UserStateStressRightEyeClosed(1))
            ->setRightEyeBrowLowerer(new UserStateStressRightEyeBrowLowerer(1))
            ->setLeftEyeBrowLowerer(new UserStateStressLeftEyeBrowLowerer(1))
            ->setLowerLipDepressorLeft(new UserStateStressLowerLipDepressorLeft(1))
            ->setLowerLipDepressorRight(new UserStateStressLowerLipDepressorRight(1))
            ->setHappy(new UserStateStressHappy(1))
            ->setHead(new UserStateStressHead(1, 1, 1))
            ->setShoulderCenter(new UserStateStressShoulderCenter(1, 1, 1))
            ->setShoulderLeft(new UserStateStressShoulderLeft(1, 1, 1))
            ->setShoulderRight(new UserStateStressShoulderRight(1, 1, 1))
            ->setHandLeft(new UserStateStressHandLeft(1, 1, 1))
            ->setHandRight(new UserStateStressHandRight(1, 1, 1))
            ->setLeanAmount(new UserStateStressLeanAmount(1, 1))
            ->setHeadRotation(new UserStateStressHeadRotation(1, 1, 1))
            ->setHeartRate(new UserStateStressHeartRate(12));
    }

    /**
     * Get user state object predefined for
     * stress module
     *
     * @return $this
     */
    protected function getUserState()
    {
        return (new \Wellbeing\Bundle\ApiBundle\Model\UserState())
            ->setAuthKey('somestring')
            ->setTimestamp(time())
            ->setTicketType('T2')
            ->setJawOpen(rand() / getrandmax())
            ->setLipPucker(rand() / getrandmax())
            ->setJawSlideRight(rand() / getrandmax())
            ->setLipStretcherLeft(rand() / getrandmax())
            ->setLipStretcherRight(rand() / getrandmax())
            ->setLipCornerPullerLeft(rand() / getrandmax())
            ->setLipCornerPullerRight(rand() / getrandmax())
            ->setLipCornerDepressorLeft(rand() / getrandmax())
            ->setLipCornerDepressorRight(rand() / getrandmax())
            ->setLeftCheekPuff(rand() / getrandmax())
            ->setRightCheekPuff(rand() / getrandmax())
            ->setLeftEyeClosed(rand() / getrandmax())
            ->setRightEyeClosed(rand() / getrandmax())
            ->setRightEyeBrowLowerer(rand(-1, 1))
            ->setLeftEyeBrowLowerer(rand(-1, 1))
            ->setLowerLipDepressorLeft(rand() / getrandmax())
            ->setLowerLipDepressorRight(rand() / getrandmax())
            ->setHappy(rand(0, 1))
            ->setHead('1.23;2.12;0.213')
            ->setShoulderCenter('1.23;2.12;0.213')
            ->setShoulderLeft('1.23;2.12;0.213')
            ->setShoulderRight('1.23;2.12;0.213')
            ->setHandLeft('1.23;2.12;0.213')
            ->setHandRight('1.23;2.12;0.213')
            ->setLeanAmount('12;20')
            ->setHeadRotation('1.23;2.12;0.213')
            ->setHeartRate(rand(40, 200));
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

        $this->assertTrue($entity instanceof UserStateStress);
    }

    public function testTransformerShouldReturnModel()
    {
        $transformer = new UserStateDataTransformer();


        $this->assertTrue($transformer->transform($this->getUserStateStress()) instanceof \Wellbeing\Bundle\ApiBundle\Model\UserState);
    }

    public function testTransformerShouldChangeDatetimeToInt()
    {
        $transformer = new UserStateDataTransformer();

        $datetime = new \DateTime('now');

        $state = $this->getUserStateStress();
        $state->setDate($datetime);

        $model = $transformer->transform($state);

        $this->assertEquals($model->getTimestamp(), $datetime->getTimestamp());
    }

    public function testTransformerShouldChangeJawOpenToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateStress();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getJawOpen(), $state->getJawOpen()->getValue());
    }

    public function testTransformerShouldChangeLipPuckerToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateStress();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getLipPucker(), $state->getLipPucker()->getValue());
    }

    public function testTransformerShouldChangeJawSlideRightToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateStress();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getJawSlideRight(), $state->getJawSlideRight()->getValue());
    }

    public function testTransformerShouldChangeLipStretcherRightToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateStress();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getLipStretcherRight(), $state->getLipStretcherRight()->getValue());
    }

    public function testTransformerShouldChangeLipStretcherLeftToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateStress();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getLipStretcherLeft(), $state->getLipStretcherLeft()->getValue());
    }

    public function testTransformerShouldChangeLipCornerPullerLeftToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateStress();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getLipCornerPullerLeft(), $state->getLipCornerPullerLeft()->getValue());
    }

    public function testTransformerShouldChangeLipCornerPullerRightToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateStress();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getLipCornerPullerRight(), $state->getLipCornerPullerRight()->getValue());
    }

    public function testTransformerShouldChangeLipCornerDepressorLeftToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateStress();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getLipCornerDepressorLeft(), $state->getLipCornerDepressorLeft()->getValue());
    }

    public function testTransformerShouldChangeLipCornerDepressorRightToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateStress();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getLipCornerDepressorRight(), $state->getLipCornerDepressorRight()->getValue());
    }

    public function testTransformerShouldChangeLeftCheekPuffToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateStress();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getLeftCheekPuff(), $state->getLeftCheekPuff()->getValue());
    }

    public function testTransformerShouldChangeRightCheekPuffToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateStress();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getRightCheekPuff(), $state->getRightCheekPuff()->getValue());
    }

    public function testTransformerShouldChangeLeftEyeClosedToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateStress();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getLeftEyeClosed(), $state->getLeftEyeClosed()->getValue());
    }

    public function testTransformerShouldChangeRightEyeClosedToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateStress();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getRightEyeClosed(), $state->getRightEyeClosed()->getValue());
    }

    public function testTransformerShouldChangeRightEyeBrowLowererToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateStress();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getRightEyeBrowLowerer(), $state->getRightEyeBrowLowerer()->getValue());
    }

    public function testTransformerShouldChangeLeftEyeBrowLowererToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateStress();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getLeftEyeBrowLowerer(), $state->getLeftEyeBrowLowerer()->getValue());
    }

    public function testTransformerShouldChangeLowerLipDepressorLeftToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateStress();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getLowerLipDepressorLeft(), $state->getLowerLipDepressorLeft()->getValue());
    }

    public function testTransformerShouldChangeHappyToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateStress();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getHappy(), $state->getHappy()->getValue());
    }

    public function testTransformerShouldChangeHeadToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateStress();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getHead(), "{$state->getHead()->getX()};{$state->getHead()->getY()};{$state->getHead()->getZ()}");
    }

    public function testTransformerShouldChangeShoulderCenterToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateStress();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getShoulderCenter(), "{$state->getShoulderCenter()->getX()};{$state->getShoulderCenter()->getY()};{$state->getShoulderCenter()->getZ()}");
    }

    public function testTransformerShouldChangeShoulderLeftToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateStress();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getShoulderLeft(), "{$state->getShoulderLeft()->getX()};{$state->getShoulderLeft()->getY()};{$state->getShoulderLeft()->getZ()}");
    }

    public function testTransformerShouldChangeShoulderRightToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateStress();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getShoulderRight(), "{$state->getShoulderRight()->getX()};{$state->getShoulderRight()->getY()};{$state->getShoulderRight()->getZ()}");
    }

    public function testTransformerShouldChangeHandLeftToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateStress();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getHandLeft(), "{$state->getHandLeft()->getX()};{$state->getHandLeft()->getY()};{$state->getHandLeft()->getZ()}");
    }

    public function testTransformerShouldChangeHandRightToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateStress();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getHandRight(), "{$state->getHandRight()->getX()};{$state->getHandRight()->getY()};{$state->getHandRight()->getZ()}");
    }

    public function testTransformerShouldChangeLeanAmountToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateStress();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getLeanAmount(), "{$state->getLeanAmount()->getX()};{$state->getLeanAmount()->getY()}");
    }

    public function testTransformerShouldChangeHeadRotationToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateStress();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getHeadRotation(), "{$state->getHeadRotation()->getX()};{$state->getHeadRotation()->getY()};{$state->getHeadRotation()->getZ()}");
    }

    public function testTransformerShouldHeartRateToString()
    {
        $transformer = new UserStateDataTransformer();

        $state = $this->getUserStateStress();

        $model = $transformer->transform($state);

        $this->assertEquals($model->getHeartRate(), $state->getHeartRate()->getValue());
    }

    public function testReverseTransformerShouldReturnCorrectObject()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertTrue($entity instanceof UserStateStress);
    }


    public function testTransformerShouldChangeJawOpenToObject()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals($model->getJawOpen(), $entity->getJawOpen()->getValue());
    }

    public function testTransformerShouldChangeLipPuckerToObject()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals($model->getLipPucker(), $entity->getLipPucker()->getValue());
    }

    public function testTransformerShouldChangeJawSlideRightToObject()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals($model->getJawSlideRight(), $entity->getJawSlideRight()->getValue());
    }

    public function testTransformerShouldChangeLipStretcherRightToObject()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals($model->getLipStretcherRight(), $entity->getLipStretcherRight()->getValue());
    }

    public function testTransformerShouldChangeLipStretcherLeftToObject()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals($model->getLipStretcherLeft(), $entity->getLipStretcherLeft()->getValue());
    }

    public function testTransformerShouldChangeLipCornerPullerLeftToObject()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals($model->getLipCornerPullerLeft(), $entity->getLipCornerPullerLeft()->getValue());
    }

    public function testTransformerShouldChangeLipCornerPullerRightToObject()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals($model->getLipCornerPullerRight(), $entity->getLipCornerPullerRight()->getValue());
    }

    public function testTransformerShouldChangeLipCornerDepressorLeftToObject()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals($model->getLipCornerDepressorLeft(), $entity->getLipCornerDepressorLeft()->getValue());
    }

    public function testTransformerShouldChangeLipCornerDepressorRightToObject()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals($model->getLipCornerDepressorRight(), $entity->getLipCornerDepressorRight()->getValue());
    }

    public function testTransformerShouldChangeLeftCheekPuffToObject()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals($model->getLeftCheekPuff(), $entity->getLeftCheekPuff()->getValue());
    }

    public function testTransformerShouldChangeRightCheekPuffToObject()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals($model->getRightCheekPuff(), $entity->getRightCheekPuff()->getValue());
    }

    public function testTransformerShouldChangeLeftEyeClosedToObject()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals($model->getLeftEyeClosed(), $entity->getLeftEyeClosed()->getValue());
    }

    public function testTransformerShouldChangeRightEyeClosedToObject()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals($model->getRightEyeClosed(), $entity->getRightEyeClosed()->getValue());
    }

    public function testTransformerShouldChangeRightEyeBrowLowererToObject()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals($model->getRightEyeBrowLowerer(), $entity->getRightEyeBrowLowerer()->getValue());
    }

    public function testTransformerShouldChangeLeftEyeBrowLowererToObject()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals($model->getLeftEyeBrowLowerer(), $entity->getLeftEyeBrowLowerer()->getValue());
    }

    public function testTransformerShouldChangeLowerLipDepressorLeftToObject()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals($model->getLowerLipDepressorLeft(), $entity->getLowerLipDepressorLeft()->getValue());
    }

    public function testTransformerShouldChangeHappyToObject()
    {
        $transformer = new UserStateDataTransformer();

        $model = $this->getUserState();

        $entity = $transformer->reverseTransform($model);

        $this->assertEquals($model->getHappy(), $entity->getHappy()->getValue());
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
}