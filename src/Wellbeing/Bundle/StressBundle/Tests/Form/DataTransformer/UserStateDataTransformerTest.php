<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 18/02/15
 * Time: 11:13
 */
namespace Wellbeing\Bundle\StressBundle\Tests\Form\DataTransformer;


use Wellbeing\Bundle\StressBundle\Entity\UserStateStress;
use Wellbeing\Bundle\StressBundle\Form\DataTransformer\UserStateDataTransformer;

class UserStateDataTransformerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Get user state object predefined for
     * stress module
     *
     * @return $this
     */
    protected function getUserStateStress()
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

        $model = $this->getUserStateStress();

        $entity = $transformer->reverseTransform($model);

        $this->assertTrue($entity instanceof UserStateStress);
    }






//    public function testTransformerShouldReturnModel()
//    {
//        $transformer = new UserStateDataTransformer();
//
//
//        $this->assertTrue($transformer->transform($this->getUserState()) instanceof \Wellbeing\Bundle\ApiBundle\Model\UserState);
//    }
//
//    public function testTransformerShouldChangeDatetimeToInt()
//    {
//        $transformer = new UserStateDataTransformer();
//
//        $datetime = new \DateTime('now');
//
//        $state = $this->getUserState();
//        $state->setDate($datetime);
//
//        $model = $transformer->transform($state);
//
//        $this->assertEquals($model->getTimestamp(), $datetime->getTimestamp());
//    }
//
//    public function testTransformerShouldChangeHeadToString()
//    {
//        $transformer = new UserStateDataTransformer();
//
//        $state = $this->getUserState();
//
//        $model = $transformer->transform($state);
//
//        $this->assertEquals($model->getHead(), "{$state->getHead()->getX()};{$state->getHead()->getY()};{$state->getHead()->getZ()}");
//    }
//
//    public function testTransformerShouldChangeShoulderLeftToString()
//    {
//        $transformer = new UserStateDataTransformer();
//
//        $state = $this->getUserState();
//
//        $model = $transformer->transform($state);
//
//        $this->assertEquals($model->getShoulderLeft(), "{$state->getShoulderLeft()->getX()};{$state->getShoulderLeft()->getY()};{$state->getShoulderLeft()->getZ()}");
//    }
//
//    public function testTransformerShouldChangeShoulderCenterToString()
//    {
//        $transformer = new UserStateDataTransformer();
//
//        $state = $this->getUserState();
//
//        $model = $transformer->transform($state);
//
//        $this->assertEquals($model->getShoulderCenter(), "{$state->getShoulderCenter()->getX()};{$state->getShoulderCenter()->getY()};{$state->getShoulderCenter()->getZ()}");
//    }
//
//    public function testTransformerShouldChangeShoulderRightToString()
//    {
//        $transformer = new UserStateDataTransformer();
//
//        $state = $this->getUserState();
//
//        $model = $transformer->transform($state);
//
//        $this->assertEquals($model->getShoulderRight(), "{$state->getShoulderRight()->getX()};{$state->getShoulderRight()->getY()};{$state->getShoulderRight()->getZ()}");
//    }
//
//    public function testTransformerShouldChangeElbowLeftToString()
//    {
//        $transformer = new UserStateDataTransformer();
//
//        $state = $this->getUserState();
//
//        $model = $transformer->transform($state);
//
//        $this->assertEquals($model->getElbowLeft(), "{$state->getElbowLeft()->getX()};{$state->getElbowLeft()->getY()};{$state->getElbowLeft()->getZ()}");
//    }
//
//    public function testTransformerShouldChangeElbowRightToString()
//    {
//        $transformer = new UserStateDataTransformer();
//
//        $state = $this->getUserState();
//
//        $model = $transformer->transform($state);
//
//        $this->assertEquals($model->getElbowRight(), "{$state->getElbowRight()->getX()};{$state->getElbowRight()->getY()};{$state->getElbowRight()->getZ()}");
//    }
//
//    public function testTransformerShouldChangeHandLeftToString()
//    {
//        $transformer = new UserStateDataTransformer();
//
//        $state = $this->getUserState();
//
//        $model = $transformer->transform($state);
//
//        $this->assertEquals($model->getHandLeft(), "{$state->getHandLeft()->getX()};{$state->getHandLeft()->getY()};{$state->getHandLeft()->getZ()}");
//    }
//
//    public function testTransformerShouldChangeHandRightToString()
//    {
//        $transformer = new UserStateDataTransformer();
//
//        $state = $this->getUserState();
//
//        $model = $transformer->transform($state);
//
//        $this->assertEquals($model->getHandRight(), "{$state->getHandRight()->getX()};{$state->getHandRight()->getY()};{$state->getHandRight()->getZ()}");
//    }
//
//    public function testTransformerShouldChangeComToString()
//    {
//        $transformer = new UserStateDataTransformer();
//
//        $state = $this->getUserState();
//
//        $model = $transformer->transform($state);
//
//        $this->assertEquals($model->getCom(), "{$state->getCom()->getX()};{$state->getCom()->getY()};{$state->getCom()->getZ()}");
//    }
//
//    public function testTransformerShouldChangeSpineToString()
//    {
//        $transformer = new UserStateDataTransformer();
//
//        $state = $this->getUserState();
//
//        $model = $transformer->transform($state);
//
//        $this->assertEquals($model->getSpine(), "{$state->getSpine()->getX()};{$state->getSpine()->getY()};{$state->getSpine()->getZ()}");
//    }
//
//    public function testTransformerShouldChangeHipLeftToString()
//    {
//        $transformer = new UserStateDataTransformer();
//
//        $state = $this->getUserState();
//
//        $model = $transformer->transform($state);
//
//        $this->assertEquals($model->getHipLeft(), "{$state->getHipLeft()->getX()};{$state->getHipLeft()->getY()};{$state->getHipLeft()->getZ()}");
//    }
//
//    public function testTransformerShouldChangeHipRightToString()
//    {
//        $transformer = new UserStateDataTransformer();
//
//        $state = $this->getUserState();
//
//        $model = $transformer->transform($state);
//
//        $this->assertEquals($model->getHipRight(), "{$state->getHipRight()->getX()};{$state->getHipRight()->getY()};{$state->getHipRight()->getZ()}");
//    }
//
//    public function testTransformerShouldChangeKneeLeftToString()
//    {
//        $transformer = new UserStateDataTransformer();
//
//        $state = $this->getUserState();
//
//        $model = $transformer->transform($state);
//
//        $this->assertEquals($model->getKneeLeft(), "{$state->getKneeLeft()->getX()};{$state->getKneeLeft()->getY()};{$state->getKneeLeft()->getZ()}");
//    }
//
//    public function testTransformerShouldChangeKneeRightToString()
//    {
//        $transformer = new UserStateDataTransformer();
//
//        $state = $this->getUserState();
//
//        $model = $transformer->transform($state);
//
//        $this->assertEquals($model->getKneeRight(), "{$state->getKneeRight()->getX()};{$state->getKneeRight()->getY()};{$state->getKneeRight()->getZ()}");
//    }
//
//    public function testTransformerShouldChangeFootLeftToString()
//    {
//        $transformer = new UserStateDataTransformer();
//
//        $state = $this->getUserState();
//
//        $model = $transformer->transform($state);
//
//        $this->assertEquals($model->getFootLeft(), "{$state->getFootLeft()->getX()};{$state->getFootLeft()->getY()};{$state->getFootLeft()->getZ()}");
//    }
//
//    public function testTransformerShouldChangeFootRightToString()
//    {
//        $transformer = new UserStateDataTransformer();
//
//        $state = $this->getUserState();
//
//        $model = $transformer->transform($state);
//
//        $this->assertEquals($model->getFootRight(), "{$state->getFootRight()->getX()};{$state->getFootRight()->getY()};{$state->getFootRight()->getZ()}");
//    }
//
//    public function testReverseTransformerShouldReturnCorrectObject()
//    {
//        $transformer = new UserStateDataTransformer();
//
//        $state = $this->getUserState();
//
//        $model = $transformer->reverseTransform($state);
//
//        $this->assertTrue($model instanceof UserState);
//    }
//
//    public function testReverseTransformerShouldChangeTimestampToDateTime()
//    {
//        $transformer = new UserStateDataTransformer();
//
//        $model = $this->getUserStateModel();
//
//        $entity = $transformer->reverseTransform($model);
//
//        $this->assertEquals($entity->getDate()->getTimestamp(), $model->getTimestamp());
//    }
//
//    public function testReverseTransformerShouldChangeHeadToCoordinate()
//    {
//        $transformer = new UserStateDataTransformer();
//
//        $model = $this->getUserStateModel();
//
//        $entity = $transformer->reverseTransform($model);
//
//        $this->assertEquals("{$entity->getHead()->getX()};{$entity->getHead()->getY()};{$entity->getHead()->getZ()}", $model->getHead());
//    }
//
//    public function testReverseTransformerShouldChangeShoulderLeftToCoordinate()
//    {
//        $transformer = new UserStateDataTransformer();
//
//        $model = $this->getUserStateModel();
//
//        $entity = $transformer->reverseTransform($model);
//
//        $this->assertEquals("{$entity->getShoulderLeft()->getX()};{$entity->getShoulderLeft()->getY()};{$entity->getShoulderLeft()->getZ()}", $model->getShoulderLeft());
//    }
//
//    public function testReverseTransformerShouldChangeShoulderCenterToCoordinate()
//    {
//        $transformer = new UserStateDataTransformer();
//
//        $model = $this->getUserStateModel();
//
//        $entity = $transformer->reverseTransform($model);
//
//        $this->assertEquals("{$entity->getShoulderCenter()->getX()};{$entity->getShoulderCenter()->getY()};{$entity->getShoulderCenter()->getZ()}", $model->getShoulderCenter());
//    }
//
//    public function testReverseTransformerShouldChangeShoulderRightToCoordinate()
//    {
//        $transformer = new UserStateDataTransformer();
//
//        $model = $this->getUserStateModel();
//
//        $entity = $transformer->reverseTransform($model);
//
//        $this->assertEquals("{$entity->getShoulderRight()->getX()};{$entity->getShoulderRight()->getY()};{$entity->getShoulderRight()->getZ()}", $model->getShoulderRight());
//    }
//
//    public function testReverseTransformerShouldChangeElbowLeftToCoordinate()
//    {
//        $transformer = new UserStateDataTransformer();
//
//        $model = $this->getUserStateModel();
//
//        $entity = $transformer->reverseTransform($model);
//
//        $this->assertEquals("{$entity->getElbowLeft()->getX()};{$entity->getElbowLeft()->getY()};{$entity->getElbowLeft()->getZ()}", $model->getElbowLeft());
//    }
//
//    public function testReverseTransformerShouldChangeElbowRightToCoordinate()
//    {
//        $transformer = new UserStateDataTransformer();
//
//        $model = $this->getUserStateModel();
//
//        $entity = $transformer->reverseTransform($model);
//
//        $this->assertEquals("{$entity->getElbowRight()->getX()};{$entity->getElbowRight()->getY()};{$entity->getElbowRight()->getZ()}", $model->getElbowRight());
//    }
//
//
//    public function testReverseTransformerShouldChangeHandLeftToCoordinate()
//    {
//        $transformer = new UserStateDataTransformer();
//
//        $model = $this->getUserStateModel();
//
//        $entity = $transformer->reverseTransform($model);
//
//        $this->assertEquals("{$entity->getHandLeft()->getX()};{$entity->getHandLeft()->getY()};{$entity->getHandLeft()->getZ()}", $model->getHandLeft());
//    }
//
//    public function testReverseTransformerShouldChangeHandRightToCoordinate()
//    {
//        $transformer = new UserStateDataTransformer();
//
//        $model = $this->getUserStateModel();
//
//        $entity = $transformer->reverseTransform($model);
//
//        $this->assertEquals("{$entity->getHandRight()->getX()};{$entity->getHandRight()->getY()};{$entity->getHandRight()->getZ()}", $model->getHandRight());
//    }
//
//    public function testReverseTransformerShouldChangeComToCoordinate()
//    {
//        $transformer = new UserStateDataTransformer();
//
//        $model = $this->getUserStateModel();
//
//        $entity = $transformer->reverseTransform($model);
//
//        $this->assertEquals("{$entity->getCom()->getX()};{$entity->getCom()->getY()};{$entity->getCom()->getZ()}", $model->getCom());
//    }
//
//    public function testReverseTransformerShouldChangeSpineToCoordinate()
//    {
//        $transformer = new UserStateDataTransformer();
//
//        $model = $this->getUserStateModel();
//
//        $entity = $transformer->reverseTransform($model);
//
//        $this->assertEquals("{$entity->getSpine()->getX()};{$entity->getSpine()->getY()};{$entity->getSpine()->getZ()}", $model->getSpine());
//    }
//
//    public function testReverseTransformerShouldChangeHipLeftToCoordinate()
//    {
//        $transformer = new UserStateDataTransformer();
//
//        $model = $this->getUserStateModel();
//
//        $entity = $transformer->reverseTransform($model);
//
//        $this->assertEquals("{$entity->getHipLeft()->getX()};{$entity->getHipLeft()->getY()};{$entity->getHipLeft()->getZ()}", $model->getHipLeft());
//    }
//
//    public function testReverseTransformerShouldChangeHipRightToCoordinate()
//    {
//        $transformer = new UserStateDataTransformer();
//
//        $model = $this->getUserStateModel();
//
//        $entity = $transformer->reverseTransform($model);
//
//        $this->assertEquals("{$entity->getHipRight()->getX()};{$entity->getHipRight()->getY()};{$entity->getHipRight()->getZ()}", $model->getHipRight());
//    }
//
//    public function testReverseTransformerShouldChangeKneeLeftToCoordinate()
//    {
//        $transformer = new UserStateDataTransformer();
//
//        $model = $this->getUserStateModel();
//
//        $entity = $transformer->reverseTransform($model);
//
//        $this->assertEquals("{$entity->getKneeLeft()->getX()};{$entity->getKneeLeft()->getY()};{$entity->getKneeLeft()->getZ()}", $model->getKneeLeft());
//    }
//
//    public function testReverseTransformerShouldChangeKneeRightToCoordinate()
//    {
//        $transformer = new UserStateDataTransformer();
//
//        $model = $this->getUserStateModel();
//
//        $entity = $transformer->reverseTransform($model);
//
//        $this->assertEquals("{$entity->getKneeRight()->getX()};{$entity->getKneeRight()->getY()};{$entity->getKneeRight()->getZ()}", $model->getKneeRight());
//    }
//
//    public function testReverseTransformerShouldChangeFootLeftToCoordinate()
//    {
//        $transformer = new UserStateDataTransformer();
//
//        $model = $this->getUserStateModel();
//
//        $entity = $transformer->reverseTransform($model);
//
//        $this->assertEquals("{$entity->getFootLeft()->getX()};{$entity->getFootLeft()->getY()};{$entity->getFootLeft()->getZ()}", $model->getFootLeft());
//    }
//
//    public function testReverseTransformerShouldChangeFootRightToCoordinate()
//    {
//        $transformer = new UserStateDataTransformer();
//
//        $model = $this->getUserStateModel();
//
//        $entity = $transformer->reverseTransform($model);
//
//        $this->assertEquals("{$entity->getFootRight()->getX()};{$entity->getFootRight()->getY()};{$entity->getFootRight()->getZ()}", $model->getFootRight());
//    }
}