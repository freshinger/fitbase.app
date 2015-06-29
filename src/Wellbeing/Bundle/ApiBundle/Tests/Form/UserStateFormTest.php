<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 18/02/15
 * Time: 12:19
 */

namespace Wellbeing\Bundle\ApiBundle\Tests\Form;


use Fitbase\Bundle\FitbaseBundle\Tests\FitbaseTestAbstract;
use Wellbeing\Bundle\ApiBundle\Form\UserState;

class UserStateFormTest extends FitbaseTestAbstract
{

    /**
     * Get user state object predefined for
     * ergonomics module
     *
     * @return $this
     */
    protected function getUserStateErgonomics()
    {
        return (new \Wellbeing\Bundle\ApiBundle\Model\UserState())
            ->setAuthKey('jqerXHGyHGaSTJSBRZmZ')
            ->setTimestamp((new \DateTime('now'))->getTimestamp())
            ->setTicketType('T1')
            ->setHead('1.23;2.12;0.213')
            ->setShoulderCenter('1.23;2.12;0.213')
            ->setShoulderLeft('1.23;2.12;0.213')
            ->setShoulderRight('1.23;2.12;0.213')
            ->setElbowLeft('1.23;2.12;0.213')
            ->setElbowRight('1.23;2.12;0.213')
            ->setHandLeft('1.23;2.12;0.213')
            ->setHandRight('1.23;2.12;0.213')
            ->setSpineMid('1.23;2.12;0.213')
            ->setLeanAmount('12;20')
            ->setHeadRotation('1.23;2.12;0.213');
    }

    /**
     * Get user state object predefined for
     * exercise module
     *
     * @return $this
     */
    protected function getUserStateExercise()
    {
        return (new \Wellbeing\Bundle\ApiBundle\Model\UserState())
            ->setAuthKey('jqerXHGyHGaSTJSBRZmZ')
            ->setTimestamp((new \DateTime('now'))->getTimestamp())
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

    /**
     * Get user state object predefined for
     * stress module
     *
     * @return $this
     */
    protected function getUserStateStress()
    {
        return (new \Wellbeing\Bundle\ApiBundle\Model\UserState())
            ->setAuthKey('jqerXHGyHGaSTJSBRZmZ')
            ->setTimestamp((new \DateTime('now'))->getTimestamp())
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

    public function testFormShouldReturnCorrectType()
    {
        $form = $this->container()->get('form.factory')
            ->create(new UserState(), $this->getUserStateErgonomics());

        $this->assertTrue($form->getData() instanceof \Wellbeing\Bundle\ApiBundle\Model\UserState);
    }


    public function testFormShouldApplySubmittedData()
    {
        $form = $this->container()->get('form.factory')
            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Model\UserState());

        $form->submit((array)json_decode((string)$this->getUserStateErgonomics()));

        $this->assertEquals($form->getData()->getAuthKey(), 'jqerXHGyHGaSTJSBRZmZ');
    }


    public function testFormShouldPassValidationForErgonomics()
    {
        $form = $this->container()->get('form.factory')
            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Model\UserState());

        $form->submit((array)json_decode((string)$this->getUserStateErgonomics()));

        $this->assertTrue($form->isValid());
    }

    public function testFormShouldPassValidationForStress()
    {
        $form = $this->container()->get('form.factory')
            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Model\UserState());

        $form->submit((array)json_decode((string)$this->getUserStateStress()));

        $this->assertTrue($form->isValid());
    }

    public function testFormShouldPassValidationForExercise()
    {
        $form = $this->container()->get('form.factory')
            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Model\UserState());

        $form->submit((array)json_decode((string)$this->getUserStateExercise()));

        $this->assertTrue($form->isValid());
    }

    public function testFormShouldNotPassValidationByAuthKey()
    {
        $form = $this->container()->get('form.factory')
            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Model\UserState());

        $entity = $this->getUserStateErgonomics()
            ->setAuthKey(null);

        $form->submit((array)json_decode((string)$entity));

        $this->assertFalse($form->isValid(), $form->getErrors()->__toString());
    }

    public function testFormShouldNotPassValidationByTimestamp()
    {
        $form = $this->container()->get('form.factory')
            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Model\UserState());

        $entity = $this->getUserStateErgonomics()
            ->setTimestamp(null);

        $form->submit((array)json_decode((string)$entity));

        $this->assertFalse($form->isValid(), $form->getErrors()->__toString());
    }

    public function testFormShouldNotPassValidationByTicketType()
    {
        $form = $this->container()->get('form.factory')
            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Model\UserState());

        $entity = $this->getUserStateErgonomics()
            ->setTicketType(null);

        $form->submit((array)json_decode((string)$entity));

        $this->assertFalse($form->isValid(), $form->getErrors()->__toString());
    }

//    public function testFormShouldNotPassValidationByShoulderCenter()
//    {
//        $form = $this->container()->get('form.factory')
//            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Entity\UserState());
//
//        $form->submit((array)\json_decode('{"authKey":"jqerXHGyHGaSTJSBRZmZ","timestamp":"1234123412","head":"2.1;2.2;2.3",
//        "shoulderCenter":"","shoulderLeft":"3.1;3.2;3.3","shoulderRight":"4.1;4.2;4.3","elbowLeft":"5.1;5.2;5.3",
//        "elbowRight":"5.1;5.2;5.3","handLeft":"5.1;5.2;5.3","handRight":"5.1;5.2;5.3","com":"5.1;5.2;5.3",
//        "spine":"5.1;5.2;5.3","hipLeft":"5.1;5.2;5.3","hipRight":"5.1;5.2;5.3","kneeLeft":"5.1;5.2;5.3",
//        "kneeRight":"5.1;5.2;5.3","footLeft":"5.1;5.2;5.3","footRight":"5.1;5.2;5.3"}'));
//
//
//        $this->assertFalse($form->isValid(), $form->getErrors()->__toString());
//    }
//
//
//    public function testFormShouldNotPassValidationByShoulderLeft()
//    {
//        $form = $this->container()->get('form.factory')
//            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Entity\UserState());
//
//        $form->submit((array)\json_decode('{"authKey":"jqerXHGyHGaSTJSBRZmZ","timestamp":"1234123412","head":"2.1;2.2;2.3",
//        "shoulderCenter":"3.1;3.2;3.3","shoulderLeft":"","shoulderRight":"4.1;4.2;4.3","elbowLeft":"5.1;5.2;5.3",
//        "elbowRight":"5.1;5.2;5.3","handLeft":"5.1;5.2;5.3","handRight":"5.1;5.2;5.3","com":"5.1;5.2;5.3",
//        "spine":"5.1;5.2;5.3","hipLeft":"5.1;5.2;5.3","hipRight":"5.1;5.2;5.3","kneeLeft":"5.1;5.2;5.3",
//        "kneeRight":"5.1;5.2;5.3","footLeft":"5.1;5.2;5.3","footRight":"5.1;5.2;5.3"}'));
//
//
//        $this->assertFalse($form->isValid(), $form->getErrors()->__toString());
//    }
//
//    public function testFormShouldNotPassValidationByShoulderRight()
//    {
//        $form = $this->container()->get('form.factory')
//            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Entity\UserState());
//
//        $form->submit((array)\json_decode('{"authKey":"asdfsdf","timestamp":"1234123412","head":"2.1;2.2;2.3",
//        "shoulderCenter":"3.1;3.2;3.3","shoulderLeft":"4.1;4.2;4.3","shoulderRight":"","elbowLeft":"5.1;5.2;5.3",
//        "elbowRight":"5.1;5.2;5.3","handLeft":"5.1;5.2;5.3","handRight":"5.1;5.2;5.3","com":"5.1;5.2;5.3",
//        "spine":"5.1;5.2;5.3","hipLeft":"5.1;5.2;5.3","hipRight":"5.1;5.2;5.3","kneeLeft":"5.1;5.2;5.3",
//        "kneeRight":"5.1;5.2;5.3","footLeft":"5.1;5.2;5.3","footRight":"5.1;5.2;5.3"}'));
//
//        $this->assertFalse($form->isValid());
//    }
//
//
//    public function testFormShouldNotPassValidationByElbowLeft()
//    {
//        $form = $this->container()->get('form.factory')
//            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Entity\UserState());
//
//        $form->submit((array)\json_decode('{"authKey":"asdfsdf","timestamp":"1234123412","head":"2.1;2.2;2.3",
//        "shoulderCenter":"3.1;3.2;3.3","shoulderLeft":"4.1;4.2;4.3","shoulderRight":"5.1;5.2;5.3","elbowLeft":"",
//        "elbowRight":"5.1;5.2;5.3","handLeft":"5.1;5.2;5.3","handRight":"5.1;5.2;5.3","com":"5.1;5.2;5.3",
//        "spine":"5.1;5.2;5.3","hipLeft":"5.1;5.2;5.3","hipRight":"5.1;5.2;5.3","kneeLeft":"5.1;5.2;5.3",
//        "kneeRight":"5.1;5.2;5.3","footLeft":"5.1;5.2;5.3","footRight":"5.1;5.2;5.3"}'));
//
//        $this->assertFalse($form->isValid());
//    }
//
//    public function testFormShouldNotPassValidationByElbowRight()
//    {
//        $form = $this->container()->get('form.factory')
//            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Entity\UserState());
//
//        $form->submit((array)\json_decode('{"authKey":"asdfsdf","timestamp":"1234123412","head":"2.1;2.2;2.3",
//        "shoulderCenter":"3.1;3.2;3.3","shoulderLeft":"4.1;4.2;4.3","shoulderRight":"5.1;5.2;5.3","elbowLeft":"5.1;5.2;5.3",
//        "elbowRight":"","handLeft":"5.1;5.2;5.3","handRight":"5.1;5.2;5.3","com":"5.1;5.2;5.3",
//        "spine":"5.1;5.2;5.3","hipLeft":"5.1;5.2;5.3","hipRight":"5.1;5.2;5.3","kneeLeft":"5.1;5.2;5.3",
//        "kneeRight":"5.1;5.2;5.3","footLeft":"5.1;5.2;5.3","footRight":"5.1;5.2;5.3"}'));
//
//        $this->assertFalse($form->isValid());
//    }
//
//
//    public function testFormShouldNotPassValidationByHandLeft()
//    {
//        $form = $this->container()->get('form.factory')
//            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Entity\UserState());
//
//        $form->submit((array)\json_decode('{"authKey":"asdfsdf","timestamp":"1234123412","head":"2.1;2.2;2.3",
//        "shoulderCenter":"3.1;3.2;3.3","shoulderLeft":"4.1;4.2;4.3","shoulderRight":"5.1;5.2;5.3","elbowLeft":"5.1;5.2;5.3",
//        "elbowRight":"5.1;5.2;5.3","handLeft":"","handRight":"5.1;5.2;5.3","com":"5.1;5.2;5.3",
//        "spine":"5.1;5.2;5.3","hipLeft":"5.1;5.2;5.3","hipRight":"5.1;5.2;5.3","kneeLeft":"5.1;5.2;5.3",
//        "kneeRight":"5.1;5.2;5.3","footLeft":"5.1;5.2;5.3","footRight":"5.1;5.2;5.3"}'));
//
//        $this->assertFalse($form->isValid());
//    }
//
//
//    public function testFormShouldNotPassValidationByHandRight()
//    {
//        $form = $this->container()->get('form.factory')
//            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Entity\UserState());
//
//        $form->submit((array)\json_decode('{"authKey":"asdfsdf","timestamp":"1234123412","head":"2.1;2.2;2.3",
//        "shoulderCenter":"3.1;3.2;3.3","shoulderLeft":"4.1;4.2;4.3","shoulderRight":"5.1;5.2;5.3","elbowLeft":"5.1;5.2;5.3",
//        "elbowRight":"5.1;5.2;5.3","handLeft":"5.1;5.2;5.3","handRight":"","com":"5.1;5.2;5.3",
//        "spine":"5.1;5.2;5.3","hipLeft":"5.1;5.2;5.3","hipRight":"5.1;5.2;5.3","kneeLeft":"5.1;5.2;5.3",
//        "kneeRight":"5.1;5.2;5.3","footLeft":"5.1;5.2;5.3","footRight":"5.1;5.2;5.3"}'));
//
//        $this->assertFalse($form->isValid());
//    }
//
//    public function testFormShouldNotPassValidationByCom()
//    {
//        $form = $this->container()->get('form.factory')
//            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Entity\UserState());
//
//        $form->submit((array)\json_decode('{"authKey":"asdfsdf","timestamp":"1234123412","head":"2.1;2.2;2.3",
//        "shoulderCenter":"3.1;3.2;3.3","shoulderLeft":"4.1;4.2;4.3","shoulderRight":"5.1;5.2;5.3","elbowLeft":"5.1;5.2;5.3",
//        "elbowRight":"5.1;5.2;5.3","handLeft":"5.1;5.2;5.3","handRight":"5.1;5.2;5.3","com":"",
//        "spine":"5.1;5.2;5.3","hipLeft":"5.1;5.2;5.3","hipRight":"5.1;5.2;5.3","kneeLeft":"5.1;5.2;5.3",
//        "kneeRight":"5.1;5.2;5.3","footLeft":"5.1;5.2;5.3","footRight":"5.1;5.2;5.3"}'));
//
//        $this->assertFalse($form->isValid());
//    }
//
//    public function testFormShouldNotPassValidationBySpine()
//    {
//        $form = $this->container()->get('form.factory')
//            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Entity\UserState());
//
//        $form->submit((array)\json_decode('{"authKey":"asdfsdf","timestamp":"1234123412","head":"2.1;2.2;2.3",
//        "shoulderCenter":"3.1;3.2;3.3","shoulderLeft":"4.1;4.2;4.3","shoulderRight":"5.1;5.2;5.3","elbowLeft":"5.1;5.2;5.3",
//        "elbowRight":"5.1;5.2;5.3","handLeft":"5.1;5.2;5.3","handRight":"5.1;5.2;5.3","com":"5.1;5.2;5.3",
//        "spine":"","hipLeft":"5.1;5.2;5.3","hipRight":"5.1;5.2;5.3","kneeLeft":"5.1;5.2;5.3",
//        "kneeRight":"5.1;5.2;5.3","footLeft":"5.1;5.2;5.3","footRight":"5.1;5.2;5.3"}'));
//
//        $this->assertFalse($form->isValid());
//    }
//
//    public function testFormShouldNotPassValidationByHipLeft()
//    {
//        $form = $this->container()->get('form.factory')
//            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Entity\UserState());
//
//        $form->submit((array)\json_decode('{"authKey":"asdfsdf","timestamp":"1234123412","head":"2.1;2.2;2.3",
//        "shoulderCenter":"3.1;3.2;3.3","shoulderLeft":"4.1;4.2;4.3","shoulderRight":"5.1;5.2;5.3","elbowLeft":"5.1;5.2;5.3",
//        "elbowRight":"5.1;5.2;5.3","handLeft":"5.1;5.2;5.3","handRight":"5.1;5.2;5.3","com":"5.1;5.2;5.3",
//        "spine":"5.1;5.2;5.3","hipLeft":"","hipRight":"5.1;5.2;5.3","kneeLeft":"5.1;5.2;5.3",
//        "kneeRight":"5.1;5.2;5.3","footLeft":"5.1;5.2;5.3","footRight":"5.1;5.2;5.3"}'));
//
//        $this->assertFalse($form->isValid());
//    }
//
//    public function testFormShouldNotPassValidationByHipRight()
//    {
//        $form = $this->container()->get('form.factory')
//            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Entity\UserState());
//
//        $form->submit((array)\json_decode('{"authKey":"asdfsdf","timestamp":"1234123412","head":"2.1;2.2;2.3",
//        "shoulderCenter":"3.1;3.2;3.3","shoulderLeft":"4.1;4.2;4.3","shoulderRight":"5.1;5.2;5.3","elbowLeft":"5.1;5.2;5.3",
//        "elbowRight":"5.1;5.2;5.3","handLeft":"5.1;5.2;5.3","handRight":"5.1;5.2;5.3","com":"5.1;5.2;5.3",
//        "spine":"5.1;5.2;5.3","hipLeft":"5.1;5.2;5.3","hipRight":"","kneeLeft":"5.1;5.2;5.3",
//        "kneeRight":"5.1;5.2;5.3","footLeft":"5.1;5.2;5.3","footRight":"5.1;5.2;5.3"}'));
//
//        $this->assertFalse($form->isValid());
//    }
//
//
//    public function testFormShouldNotPassValidationByKneeLeft()
//    {
//        $form = $this->container()->get('form.factory')
//            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Entity\UserState());
//
//        $form->submit((array)\json_decode('{"authKey":"asdfsdf","timestamp":"1234123412","head":"2.1;2.2;2.3",
//        "shoulderCenter":"3.1;3.2;3.3","shoulderLeft":"4.1;4.2;4.3","shoulderRight":"5.1;5.2;5.3","elbowLeft":"5.1;5.2;5.3",
//        "elbowRight":"5.1;5.2;5.3","handLeft":"5.1;5.2;5.3","handRight":"5.1;5.2;5.3","com":"5.1;5.2;5.3",
//        "spine":"5.1;5.2;5.3","hipLeft":"5.1;5.2;5.3","hipRight":"5.1;5.2;5.3","kneeLeft":"",
//        "kneeRight":"5.1;5.2;5.3","footLeft":"5.1;5.2;5.3","footRight":"5.1;5.2;5.3"}'));
//
//        $this->assertFalse($form->isValid());
//    }
//
//    public function testFormShouldNotPassValidationByKneeRight()
//    {
//        $form = $this->container()->get('form.factory')
//            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Entity\UserState());
//
//        $form->submit((array)\json_decode('{"authKey":"asdfsdf","timestamp":"1234123412","head":"2.1;2.2;2.3",
//        "shoulderCenter":"3.1;3.2;3.3","shoulderLeft":"4.1;4.2;4.3","shoulderRight":"5.1;5.2;5.3","elbowLeft":"5.1;5.2;5.3",
//        "elbowRight":"5.1;5.2;5.3","handLeft":"5.1;5.2;5.3","handRight":"5.1;5.2;5.3","com":"5.1;5.2;5.3",
//        "spine":"5.1;5.2;5.3","hipLeft":"5.1;5.2;5.3","hipRight":"5.1;5.2;5.3","kneeLeft":"5.1;5.2;5.3",
//        "kneeRight":"","footLeft":"5.1;5.2;5.3","footRight":"5.1;5.2;5.3"}'));
//
//        $this->assertFalse($form->isValid());
//    }
//
//    public function testFormShouldNotPassValidationByFootLeft()
//    {
//        $form = $this->container()->get('form.factory')
//            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Entity\UserState());
//
//        $form->submit((array)\json_decode('{"authKey":"asdfsdf","timestamp":"1234123412","head":"2.1;2.2;2.3",
//        "shoulderCenter":"3.1;3.2;3.3","shoulderLeft":"4.1;4.2;4.3","shoulderRight":"5.1;5.2;5.3","elbowLeft":"5.1;5.2;5.3",
//        "elbowRight":"5.1;5.2;5.3","handLeft":"5.1;5.2;5.3","handRight":"5.1;5.2;5.3","com":"5.1;5.2;5.3",
//        "spine":"5.1;5.2;5.3","hipLeft":"5.1;5.2;5.3","hipRight":"5.1;5.2;5.3","kneeLeft":"5.1;5.2;5.3",
//        "kneeRight":"5.1;5.2;5.3","footLeft":"","footRight":"5.1;5.2;5.3"}'));
//
//        $this->assertFalse($form->isValid());
//    }
//
//    public function testFormShouldNotPassValidationByFootRight()
//    {
//        $form = $this->container()->get('form.factory')
//            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Entity\UserState());
//
//        $form->submit((array)\json_decode('{"authKey":"asdfsdf","timestamp":"1234123412","head":"2.1;2.2;2.3", "shoulderCenter":"3.1;3.2;3.3","shoulderLeft":"4.1;4.2;4.3","shoulderRight":"5.1;5.2;5.3","elbowLeft":"5.1;5.2;5.3", "elbowRight":"5.1;5.2;5.3","handLeft":"5.1;5.2;5.3","handRight":"5.1;5.2;5.3","com":"5.1;5.2;5.3", "spine":"5.1;5.2;5.3","hipLeft":"5.1;5.2;5.3","hipRight":"5.1;5.2;5.3","kneeLeft":"5.1;5.2;5.3", "kneeRight":"5.1;5.2;5.3","footLeft":"5.1;5.2;5.3","footRight":""}'));
//
//        $this->assertFalse($form->isValid());
//    }

//    public function testFormShouldStoreInDatabase()
//    {
//        $form = $this->container()->get('form.factory')
//            ->create(new UserState(), $this->getUserState());
//
//
//        $entityManager = $this->container()->get('entity_manager');
//        $repositoryUser = $entityManager->getRepository('Application\Sonata\UserBundle\Entity\User');
//
//        $form->getData()->setUser($repositoryUser->find(1));
//        $entityManager->persist($form->getData());
//        $entityManager->flush($form->getData());
//
//
////        if ($form->isValid()) {
//    }

}