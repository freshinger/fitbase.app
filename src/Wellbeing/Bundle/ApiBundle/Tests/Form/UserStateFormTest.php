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

    public function testFormShouldAppySubmittedData()
    {
        $form = $this->container()->get('form.factory')
            ->create(new UserState(), $this->getUserState());

        $form->submit(array(
            "authKey" => "test"
        ));

        $this->assertEquals($form->getData()->getAuthKey(), "test");
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