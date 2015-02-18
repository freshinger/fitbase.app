<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 18/02/15
 * Time: 12:19
 */

namespace Wellbeing\Bundle\ApiBundle\Tests\Form;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Wellbeing\Bundle\ApiBundle\Entity\Coordinate;
use Wellbeing\Bundle\ApiBundle\Form\DataTransformer\UserStateDataTransformer;
use Wellbeing\Bundle\ApiBundle\Form\UserState;

class UserStateFormTest extends WebTestCase
{
    protected function getUserStateModel()
    {
        return (new \Wellbeing\Bundle\ApiBundle\Model\UserState())
            ->setAuthKey("afdgsdfgklmaljga")
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

    protected function getUserState()
    {
        return (new \Wellbeing\Bundle\ApiBundle\Entity\UserState())
            ->setDate(new \DateTime('now'))
            ->setHead(
                (new Coordinate())
                    ->setX(1.1)
                    ->setY(1.2)
                    ->setZ(1.3)
            )
            ->setShoulderLeft(
                (new Coordinate())
                    ->setX(2.1)
                    ->setY(2.2)
                    ->setZ(2.3)
            )
            ->setShoulderCenter(
                (new Coordinate())
                    ->setX(3.1)
                    ->setY(3.2)
                    ->setZ(3.3)
            )
            ->setShoulderRight(
                (new Coordinate())
                    ->setX(4.1)
                    ->setY(4.2)
                    ->setZ(4.3)
            )
            ->setElbowLeft(
                (new Coordinate())
                    ->setX(5.1)
                    ->setY(5.2)
                    ->setZ(5.3)
            )
            ->setElbowRight(
                (new Coordinate())
                    ->setX(6.1)
                    ->setY(6.3)
                    ->setZ(6.3)
            )
            ->setHandLeft(
                (new Coordinate())
                    ->setX(7.1)
                    ->setY(7.2)
                    ->setZ(7.3)
            )
            ->setHandRight(
                (new Coordinate())
                    ->setX(8.1)
                    ->setY(8.2)
                    ->setZ(8.3)
            )
            ->setCom(
                (new Coordinate())
                    ->setX(9.1)
                    ->setY(9.2)
                    ->setZ(9.3)
            )
            ->setSpine(
                (new Coordinate())
                    ->setX(10.1)
                    ->setY(10.2)
                    ->setZ(10.3)
            )
            ->setHipLeft(
                (new Coordinate())
                    ->setX(13.1)
                    ->setY(13.2)
                    ->setZ(12.3)
            )
            ->setHipRight(
                (new Coordinate())
                    ->setX(14.1)
                    ->setY(14.2)
                    ->setZ(14.3)
            )
            ->setKneeLeft(
                (new Coordinate())
                    ->setX(15.1)
                    ->setY(15.2)
                    ->setZ(15.3)
            )
            ->setKneeRight(
                (new Coordinate())
                    ->setX(16.1)
                    ->setY(16.2)
                    ->setZ(16.3)
            )
            ->setFootLeft(
                (new Coordinate())
                    ->setX(17.1)
                    ->setY(17.2)
                    ->setZ(17.3)
            )
            ->setFootRight(
                (new Coordinate())
                    ->setX(18.1)
                    ->setY(18.2)
                    ->setZ(18.3)
            );
    }

    protected function container(array $options = array(), array $server = array())
    {
        static::bootKernel($options);
        return static::$kernel->getContainer();
    }

    public function testFormShouldReturnCorrectType()
    {
        $form = $this->container()->get('form.factory')
            ->create(new UserState(), $this->getUserState());

        $this->assertTrue($form->getData() instanceof \Wellbeing\Bundle\ApiBundle\Entity\UserState);
    }


    public function testFormShouldReturnCorrectViewType()
    {
        $entity = $this->getUserState();


        $model = (new UserStateDataTransformer())->transform($entity);

        $form = $this->container()->get('form.factory')
            ->create(new UserState(), $this->getUserState());


        $this->assertTrue(array_key_exists('authKey', $form->createView()->children));
        $this->assertEquals($form->createView()->children['authkey']->vars['value'], null);

        $this->assertTrue(array_key_exists('timestamp', $form->createView()->children));
        $this->assertEquals($form->createView()->children['timestamp']->vars['value'], $model->getTimestamp());

        $this->assertTrue(array_key_exists('head', $form->createView()->children));
        $this->assertEquals($form->createView()->children['head']->vars['value'], $model->getHead());

        $this->assertTrue(array_key_exists('shoulderLeft', $form->createView()->children));
        $this->assertEquals($form->createView()->children['shoulderLeft']->vars['value'], $model->getShoulderLeft());

        $this->assertTrue(array_key_exists('shoulderCenter', $form->createView()->children));
        $this->assertEquals($form->createView()->children['shoulderCenter']->vars['value'], $model->getShoulderCenter());

        $this->assertTrue(array_key_exists('shoulderRight', $form->createView()->children));
        $this->assertEquals($form->createView()->children['shoulderRight']->vars['value'], $model->getShoulderRight());

        $this->assertTrue(array_key_exists('elbowLeft', $form->createView()->children));
        $this->assertEquals($form->createView()->children['elbowLeft']->vars['value'], $model->getElbowLeft());

        $this->assertTrue(array_key_exists('elbowRight', $form->createView()->children));
        $this->assertEquals($form->createView()->children['elbowRight']->vars['value'], $model->getElbowRight());

        $this->assertTrue(array_key_exists('handLeft', $form->createView()->children));
        $this->assertEquals($form->createView()->children['handLeft']->vars['value'], $model->getHandLeft());

        $this->assertTrue(array_key_exists('handRight', $form->createView()->children));
        $this->assertEquals($form->createView()->children['handRight']->vars['value'], $model->getHandRight());

        $this->assertTrue(array_key_exists('com', $form->createView()->children));
        $this->assertEquals($form->createView()->children['com']->vars['value'], $model->getCom());

        $this->assertTrue(array_key_exists('spine', $form->createView()->children));
        $this->assertEquals($form->createView()->children['spine']->vars['value'], $model->getSpine());

        $this->assertTrue(array_key_exists('hipLeft', $form->createView()->children));
        $this->assertEquals($form->createView()->children['hipLeft']->vars['value'], $model->getHipLeft());

        $this->assertTrue(array_key_exists('hipRight', $form->createView()->children));
        $this->assertEquals($form->createView()->children['hipRight']->vars['value'], $model->getHipRight());

        $this->assertTrue(array_key_exists('kneeLeft', $form->createView()->children));
        $this->assertEquals($form->createView()->children['kneeLeft']->vars['value'], $model->getKneeLeft());

        $this->assertTrue(array_key_exists('kneeRight', $form->createView()->children));
        $this->assertEquals($form->createView()->children['kneeRight']->vars['value'], $model->getKneeRight());

        $this->assertTrue(array_key_exists('footLeft', $form->createView()->children));
        $this->assertEquals($form->createView()->children['footLeft']->vars['value'], $model->getFootLeft());

        $this->assertTrue(array_key_exists('footRight', $form->createView()->children));
        $this->assertEquals($form->createView()->children['footRight']->vars['value'], $model->getFootRight());
    }

    public function testFormShouldApplySubmittedData()
    {
        $form = $this->container()->get('form.factory')
            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Entity\UserState());

        $form->submit((array)\json_decode('{"authKey":"jqerXHGyHGaSTJSBRZmZ","timestamp":"1234123412","head":"1.1;1.2;1.3","shoulderCenter":"2.1;2.2;2.3","shoulderLeft":"3.1;3.2;3.3","shoulderRight":"4.1;4.2;4.3","elbowLeft":"5.1;5.2;5.3","elbowRight":"5.1;5.2;5.3","handLeft":"5.1;5.2;5.3","handRight":"5.1;5.2;5.3","com":"5.1;5.2;5.3","spine":"5.1;5.2;5.3","hipLeft":"5.1;5.2;5.3","hipRight":"5.1;5.2;5.3","kneeLeft":"5.1;5.2;5.3","kneeRight":"5.1;5.2;5.3","footLeft":"5.1;5.2;5.3","footRight":"5.1;5.2;5.3"}'));

        $this->assertEquals($form->getData()->getAuthKey(), 'jqerXHGyHGaSTJSBRZmZ');

    }


    public function testFormShouldPassValidation()
    {
        $form = $this->container()->get('form.factory')
            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Entity\UserState());

        $form->submit((array)\json_decode('{"authKey":"jqerXHGyHGaSTJSBRZmZ","timestamp":"1234123412","head":"1.1;1.2;1.3","shoulderCenter":"2.1;2.2;2.3","shoulderLeft":"3.1;3.2;3.3","shoulderRight":"4.1;4.2;4.3","elbowLeft":"5.1;5.2;5.3","elbowRight":"5.1;5.2;5.3","handLeft":"5.1;5.2;5.3","handRight":"5.1;5.2;5.3","com":"5.1;5.2;5.3","spine":"5.1;5.2;5.3","hipLeft":"5.1;5.2;5.3","hipRight":"5.1;5.2;5.3","kneeLeft":"5.1;5.2;5.3","kneeRight":"5.1;5.2;5.3","footLeft":"5.1;5.2;5.3","footRight":"5.1;5.2;5.3"}'));

        $this->assertTrue($form->isValid());
    }


    public function testFormShouldNotPassValidationByAuthKey()
    {
        $form = $this->container()->get('form.factory')
            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Entity\UserState());

        $form->submit((array)\json_decode('{"authKey":"","timestamp":"1234123412","head":"1.1;1.2;1.3","shoulderCenter":"2.1;2.2;2.3","shoulderLeft":"3.1;3.2;3.3","shoulderRight":"4.1;4.2;4.3","elbowLeft":"5.1;5.2;5.3","elbowRight":"5.1;5.2;5.3","handLeft":"5.1;5.2;5.3","handRight":"5.1;5.2;5.3","com":"5.1;5.2;5.3","spine":"5.1;5.2;5.3","hipLeft":"5.1;5.2;5.3","hipRight":"5.1;5.2;5.3","kneeLeft":"5.1;5.2;5.3","kneeRight":"5.1;5.2;5.3","footLeft":"5.1;5.2;5.3","footRight":"5.1;5.2;5.3"}'));

        $this->assertFalse($form->isValid(), $form->getErrors()->__toString());
    }

    public function testFormShouldNotPassValidationByHead()
    {
        $form = $this->container()->get('form.factory')
            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Entity\UserState());

        $form->submit((array)\json_decode('{"authKey":"jqerXHGyHGaSTJSBRZmZ","timestamp":"1234123412","head":"","shoulderCenter":"2.1;2.2;2.3","shoulderLeft":"3.1;3.2;3.3","shoulderRight":"4.1;4.2;4.3","elbowLeft":"5.1;5.2;5.3","elbowRight":"5.1;5.2;5.3","handLeft":"5.1;5.2;5.3","handRight":"5.1;5.2;5.3","com":"5.1;5.2;5.3","spine":"5.1;5.2;5.3","hipLeft":"5.1;5.2;5.3","hipRight":"5.1;5.2;5.3","kneeLeft":"5.1;5.2;5.3","kneeRight":"5.1;5.2;5.3","footLeft":"5.1;5.2;5.3","footRight":"5.1;5.2;5.3"}'));


        $this->assertFalse($form->isValid(), $form->getErrors()->__toString());
    }

    public function testFormShouldNotPassValidationByShoulderCenter()
    {
        $form = $this->container()->get('form.factory')
            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Entity\UserState());

        $form->submit((array)\json_decode('{"authKey":"jqerXHGyHGaSTJSBRZmZ","timestamp":"1234123412","head":"2.1;2.2;2.3",
        "shoulderCenter":"","shoulderLeft":"3.1;3.2;3.3","shoulderRight":"4.1;4.2;4.3","elbowLeft":"5.1;5.2;5.3",
        "elbowRight":"5.1;5.2;5.3","handLeft":"5.1;5.2;5.3","handRight":"5.1;5.2;5.3","com":"5.1;5.2;5.3",
        "spine":"5.1;5.2;5.3","hipLeft":"5.1;5.2;5.3","hipRight":"5.1;5.2;5.3","kneeLeft":"5.1;5.2;5.3",
        "kneeRight":"5.1;5.2;5.3","footLeft":"5.1;5.2;5.3","footRight":"5.1;5.2;5.3"}'));


        $this->assertFalse($form->isValid(), $form->getErrors()->__toString());
    }


    public function testFormShouldNotPassValidationByShoulderLeft()
    {
        $form = $this->container()->get('form.factory')
            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Entity\UserState());

        $form->submit((array)\json_decode('{"authKey":"jqerXHGyHGaSTJSBRZmZ","timestamp":"1234123412","head":"2.1;2.2;2.3",
        "shoulderCenter":"3.1;3.2;3.3","shoulderLeft":"","shoulderRight":"4.1;4.2;4.3","elbowLeft":"5.1;5.2;5.3",
        "elbowRight":"5.1;5.2;5.3","handLeft":"5.1;5.2;5.3","handRight":"5.1;5.2;5.3","com":"5.1;5.2;5.3",
        "spine":"5.1;5.2;5.3","hipLeft":"5.1;5.2;5.3","hipRight":"5.1;5.2;5.3","kneeLeft":"5.1;5.2;5.3",
        "kneeRight":"5.1;5.2;5.3","footLeft":"5.1;5.2;5.3","footRight":"5.1;5.2;5.3"}'));


        $this->assertFalse($form->isValid(), $form->getErrors()->__toString());
    }

    public function testFormShouldNotPassValidationByShoulderRight()
    {
        $form = $this->container()->get('form.factory')
            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Entity\UserState());

        $form->submit((array)\json_decode('{"authKey":"asdfsdf","timestamp":"1234123412","head":"2.1;2.2;2.3",
        "shoulderCenter":"3.1;3.2;3.3","shoulderLeft":"4.1;4.2;4.3","shoulderRight":"","elbowLeft":"5.1;5.2;5.3",
        "elbowRight":"5.1;5.2;5.3","handLeft":"5.1;5.2;5.3","handRight":"5.1;5.2;5.3","com":"5.1;5.2;5.3",
        "spine":"5.1;5.2;5.3","hipLeft":"5.1;5.2;5.3","hipRight":"5.1;5.2;5.3","kneeLeft":"5.1;5.2;5.3",
        "kneeRight":"5.1;5.2;5.3","footLeft":"5.1;5.2;5.3","footRight":"5.1;5.2;5.3"}'));

        $this->assertFalse($form->isValid());
    }


    public function testFormShouldNotPassValidationByElbowLeft()
    {
        $form = $this->container()->get('form.factory')
            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Entity\UserState());

        $form->submit((array)\json_decode('{"authKey":"asdfsdf","timestamp":"1234123412","head":"2.1;2.2;2.3",
        "shoulderCenter":"3.1;3.2;3.3","shoulderLeft":"4.1;4.2;4.3","shoulderRight":"5.1;5.2;5.3","elbowLeft":"",
        "elbowRight":"5.1;5.2;5.3","handLeft":"5.1;5.2;5.3","handRight":"5.1;5.2;5.3","com":"5.1;5.2;5.3",
        "spine":"5.1;5.2;5.3","hipLeft":"5.1;5.2;5.3","hipRight":"5.1;5.2;5.3","kneeLeft":"5.1;5.2;5.3",
        "kneeRight":"5.1;5.2;5.3","footLeft":"5.1;5.2;5.3","footRight":"5.1;5.2;5.3"}'));

        $this->assertFalse($form->isValid());
    }

    public function testFormShouldNotPassValidationByElbowRight()
    {
        $form = $this->container()->get('form.factory')
            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Entity\UserState());

        $form->submit((array)\json_decode('{"authKey":"asdfsdf","timestamp":"1234123412","head":"2.1;2.2;2.3",
        "shoulderCenter":"3.1;3.2;3.3","shoulderLeft":"4.1;4.2;4.3","shoulderRight":"5.1;5.2;5.3","elbowLeft":"5.1;5.2;5.3",
        "elbowRight":"","handLeft":"5.1;5.2;5.3","handRight":"5.1;5.2;5.3","com":"5.1;5.2;5.3",
        "spine":"5.1;5.2;5.3","hipLeft":"5.1;5.2;5.3","hipRight":"5.1;5.2;5.3","kneeLeft":"5.1;5.2;5.3",
        "kneeRight":"5.1;5.2;5.3","footLeft":"5.1;5.2;5.3","footRight":"5.1;5.2;5.3"}'));

        $this->assertFalse($form->isValid());
    }


    public function testFormShouldNotPassValidationByHandLeft()
    {
        $form = $this->container()->get('form.factory')
            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Entity\UserState());

        $form->submit((array)\json_decode('{"authKey":"asdfsdf","timestamp":"1234123412","head":"2.1;2.2;2.3",
        "shoulderCenter":"3.1;3.2;3.3","shoulderLeft":"4.1;4.2;4.3","shoulderRight":"5.1;5.2;5.3","elbowLeft":"5.1;5.2;5.3",
        "elbowRight":"5.1;5.2;5.3","handLeft":"","handRight":"5.1;5.2;5.3","com":"5.1;5.2;5.3",
        "spine":"5.1;5.2;5.3","hipLeft":"5.1;5.2;5.3","hipRight":"5.1;5.2;5.3","kneeLeft":"5.1;5.2;5.3",
        "kneeRight":"5.1;5.2;5.3","footLeft":"5.1;5.2;5.3","footRight":"5.1;5.2;5.3"}'));

        $this->assertFalse($form->isValid());
    }


    public function testFormShouldNotPassValidationByHandRight()
    {
        $form = $this->container()->get('form.factory')
            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Entity\UserState());

        $form->submit((array)\json_decode('{"authKey":"asdfsdf","timestamp":"1234123412","head":"2.1;2.2;2.3",
        "shoulderCenter":"3.1;3.2;3.3","shoulderLeft":"4.1;4.2;4.3","shoulderRight":"5.1;5.2;5.3","elbowLeft":"5.1;5.2;5.3",
        "elbowRight":"5.1;5.2;5.3","handLeft":"5.1;5.2;5.3","handRight":"","com":"5.1;5.2;5.3",
        "spine":"5.1;5.2;5.3","hipLeft":"5.1;5.2;5.3","hipRight":"5.1;5.2;5.3","kneeLeft":"5.1;5.2;5.3",
        "kneeRight":"5.1;5.2;5.3","footLeft":"5.1;5.2;5.3","footRight":"5.1;5.2;5.3"}'));

        $this->assertFalse($form->isValid());
    }

    public function testFormShouldNotPassValidationByCom()
    {
        $form = $this->container()->get('form.factory')
            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Entity\UserState());

        $form->submit((array)\json_decode('{"authKey":"asdfsdf","timestamp":"1234123412","head":"2.1;2.2;2.3",
        "shoulderCenter":"3.1;3.2;3.3","shoulderLeft":"4.1;4.2;4.3","shoulderRight":"5.1;5.2;5.3","elbowLeft":"5.1;5.2;5.3",
        "elbowRight":"5.1;5.2;5.3","handLeft":"5.1;5.2;5.3","handRight":"5.1;5.2;5.3","com":"",
        "spine":"5.1;5.2;5.3","hipLeft":"5.1;5.2;5.3","hipRight":"5.1;5.2;5.3","kneeLeft":"5.1;5.2;5.3",
        "kneeRight":"5.1;5.2;5.3","footLeft":"5.1;5.2;5.3","footRight":"5.1;5.2;5.3"}'));

        $this->assertFalse($form->isValid());
    }

    public function testFormShouldNotPassValidationBySpine()
    {
        $form = $this->container()->get('form.factory')
            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Entity\UserState());

        $form->submit((array)\json_decode('{"authKey":"asdfsdf","timestamp":"1234123412","head":"2.1;2.2;2.3",
        "shoulderCenter":"3.1;3.2;3.3","shoulderLeft":"4.1;4.2;4.3","shoulderRight":"5.1;5.2;5.3","elbowLeft":"5.1;5.2;5.3",
        "elbowRight":"5.1;5.2;5.3","handLeft":"5.1;5.2;5.3","handRight":"5.1;5.2;5.3","com":"5.1;5.2;5.3",
        "spine":"","hipLeft":"5.1;5.2;5.3","hipRight":"5.1;5.2;5.3","kneeLeft":"5.1;5.2;5.3",
        "kneeRight":"5.1;5.2;5.3","footLeft":"5.1;5.2;5.3","footRight":"5.1;5.2;5.3"}'));

        $this->assertFalse($form->isValid());
    }

    public function testFormShouldNotPassValidationByHipLeft()
    {
        $form = $this->container()->get('form.factory')
            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Entity\UserState());

        $form->submit((array)\json_decode('{"authKey":"asdfsdf","timestamp":"1234123412","head":"2.1;2.2;2.3",
        "shoulderCenter":"3.1;3.2;3.3","shoulderLeft":"4.1;4.2;4.3","shoulderRight":"5.1;5.2;5.3","elbowLeft":"5.1;5.2;5.3",
        "elbowRight":"5.1;5.2;5.3","handLeft":"5.1;5.2;5.3","handRight":"5.1;5.2;5.3","com":"5.1;5.2;5.3",
        "spine":"5.1;5.2;5.3","hipLeft":"","hipRight":"5.1;5.2;5.3","kneeLeft":"5.1;5.2;5.3",
        "kneeRight":"5.1;5.2;5.3","footLeft":"5.1;5.2;5.3","footRight":"5.1;5.2;5.3"}'));

        $this->assertFalse($form->isValid());
    }

    public function testFormShouldNotPassValidationByHipRight()
    {
        $form = $this->container()->get('form.factory')
            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Entity\UserState());

        $form->submit((array)\json_decode('{"authKey":"asdfsdf","timestamp":"1234123412","head":"2.1;2.2;2.3",
        "shoulderCenter":"3.1;3.2;3.3","shoulderLeft":"4.1;4.2;4.3","shoulderRight":"5.1;5.2;5.3","elbowLeft":"5.1;5.2;5.3",
        "elbowRight":"5.1;5.2;5.3","handLeft":"5.1;5.2;5.3","handRight":"5.1;5.2;5.3","com":"5.1;5.2;5.3",
        "spine":"5.1;5.2;5.3","hipLeft":"5.1;5.2;5.3","hipRight":"","kneeLeft":"5.1;5.2;5.3",
        "kneeRight":"5.1;5.2;5.3","footLeft":"5.1;5.2;5.3","footRight":"5.1;5.2;5.3"}'));

        $this->assertFalse($form->isValid());
    }


    public function testFormShouldNotPassValidationByKneeLeft()
    {
        $form = $this->container()->get('form.factory')
            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Entity\UserState());

        $form->submit((array)\json_decode('{"authKey":"asdfsdf","timestamp":"1234123412","head":"2.1;2.2;2.3",
        "shoulderCenter":"3.1;3.2;3.3","shoulderLeft":"4.1;4.2;4.3","shoulderRight":"5.1;5.2;5.3","elbowLeft":"5.1;5.2;5.3",
        "elbowRight":"5.1;5.2;5.3","handLeft":"5.1;5.2;5.3","handRight":"5.1;5.2;5.3","com":"5.1;5.2;5.3",
        "spine":"5.1;5.2;5.3","hipLeft":"5.1;5.2;5.3","hipRight":"5.1;5.2;5.3","kneeLeft":"",
        "kneeRight":"5.1;5.2;5.3","footLeft":"5.1;5.2;5.3","footRight":"5.1;5.2;5.3"}'));

        $this->assertFalse($form->isValid());
    }

    public function testFormShouldNotPassValidationByKneeRight()
    {
        $form = $this->container()->get('form.factory')
            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Entity\UserState());

        $form->submit((array)\json_decode('{"authKey":"asdfsdf","timestamp":"1234123412","head":"2.1;2.2;2.3",
        "shoulderCenter":"3.1;3.2;3.3","shoulderLeft":"4.1;4.2;4.3","shoulderRight":"5.1;5.2;5.3","elbowLeft":"5.1;5.2;5.3",
        "elbowRight":"5.1;5.2;5.3","handLeft":"5.1;5.2;5.3","handRight":"5.1;5.2;5.3","com":"5.1;5.2;5.3",
        "spine":"5.1;5.2;5.3","hipLeft":"5.1;5.2;5.3","hipRight":"5.1;5.2;5.3","kneeLeft":"5.1;5.2;5.3",
        "kneeRight":"","footLeft":"5.1;5.2;5.3","footRight":"5.1;5.2;5.3"}'));

        $this->assertFalse($form->isValid());
    }

    public function testFormShouldNotPassValidationByFootLeft()
    {
        $form = $this->container()->get('form.factory')
            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Entity\UserState());

        $form->submit((array)\json_decode('{"authKey":"asdfsdf","timestamp":"1234123412","head":"2.1;2.2;2.3",
        "shoulderCenter":"3.1;3.2;3.3","shoulderLeft":"4.1;4.2;4.3","shoulderRight":"5.1;5.2;5.3","elbowLeft":"5.1;5.2;5.3",
        "elbowRight":"5.1;5.2;5.3","handLeft":"5.1;5.2;5.3","handRight":"5.1;5.2;5.3","com":"5.1;5.2;5.3",
        "spine":"5.1;5.2;5.3","hipLeft":"5.1;5.2;5.3","hipRight":"5.1;5.2;5.3","kneeLeft":"5.1;5.2;5.3",
        "kneeRight":"5.1;5.2;5.3","footLeft":"","footRight":"5.1;5.2;5.3"}'));

        $this->assertFalse($form->isValid());
    }

    public function testFormShouldNotPassValidationByFootRight()
    {
        $form = $this->container()->get('form.factory')
            ->create(new UserState(), new \Wellbeing\Bundle\ApiBundle\Entity\UserState());

        $form->submit((array)\json_decode('{"authKey":"asdfsdf","timestamp":"1234123412","head":"2.1;2.2;2.3",
        "shoulderCenter":"3.1;3.2;3.3","shoulderLeft":"4.1;4.2;4.3","shoulderRight":"5.1;5.2;5.3","elbowLeft":"5.1;5.2;5.3",
        "elbowRight":"5.1;5.2;5.3","handLeft":"5.1;5.2;5.3","handRight":"5.1;5.2;5.3","com":"5.1;5.2;5.3",
        "spine":"5.1;5.2;5.3","hipLeft":"5.1;5.2;5.3","hipRight":"5.1;5.2;5.3","kneeLeft":"5.1;5.2;5.3",
        "kneeRight":"5.1;5.2;5.3","footLeft":"5.1;5.2;5.3","footRight":""}'));

        $this->assertFalse($form->isValid());
    }

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