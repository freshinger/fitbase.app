<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 09/02/15
 * Time: 10:20
 */

namespace Fitbase\Bundle\WeeklytaskBundle\Test\Block;


use Application\Sonata\ClassificationBundle\Entity\Category;
use Application\Sonata\PageBundle\Entity\Block;
use Application\Sonata\UserBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Fitbase\Bundle\ReminderBundle\Entity\ReminderUserItem;
use Fitbase\Bundle\WeeklytaskBundle\Block\WeeklytaskCollectionBlockService;
use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskReminderEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Subscriber\WeeklytaskUserSubscriber;
use Sonata\BlockBundle\Block\BlockContext;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class WeeklytaskCollectionBlockServiceTest extends WebTestCase
{
//    protected $name;
//    protected $templating;
//    protected $serviceUser;
//    protected $objectManager;
//
//    public function setUp()
//    {
//        date_default_timezone_set('Europe/Berlin');
//
//        $this->name = 'Exercise random block';
//
//
//        $this->serviceUser = $this->getMock('ServiceUser', array(
//            'current'
//        ));
//        $this->serviceUser->expects($this->any())
//            ->method('current')
//            ->will($this->returnValue(new User()));
//
//
//        $this->objectManager = $this->getMock('\Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskManagerInterface', array(
//            'persist',
//            'exists',
//            'findOneByUserAndUnique',
//            'findAllByUserAndCategory'
//        ));
//        $this->objectManager->expects($this->any())
//            ->method('findAllByUserAndCategory')
//            ->will($this->returnValue(array(
//                (new WeeklytaskUser())->setTask((new Weeklytask())->addCategory((new Category()))),
//                (new WeeklytaskUser())->setTask((new Weeklytask())->addCategory((new Category()))),
//                (new WeeklytaskUser())->setTask((new Weeklytask())->addCategory((new Category()))),
//                (new WeeklytaskUser())->setTask((new Weeklytask())->addCategory((new Category()))),
//            )));
//
//
//        $this->templating = $this->getMock('\Symfony\Bundle\FrameworkBundle\Templating\EngineInterface', array(
//            'renderResponse', 'render', 'exists', 'supports'
//        ));
//        $this->templating->expects($this->any())
//            ->method('renderResponse')
//            ->will($this->returnValue(new Response()));
//        $this->templating->expects($this->any())
//            ->method('render')
//            ->will($this->returnValue(true));
//        $this->templating->expects($this->any())
//            ->method('exists')
//            ->will($this->returnValue(true));
//        $this->templating->expects($this->any())
//            ->method('supports')
//            ->will($this->returnValue(true));
//    }
//
//    protected function container(array $options = array(), array $server = array())
//    {
//        static::bootKernel($options);
//        return static::$kernel->getContainer();
//    }
//
//    /**
//     * Check that method create a plan
//     * for user
//     */
//    public function testBlockShouldReturnResponseWithCode200()
//    {
//        $blockContext = new BlockContext(new Block(), array(
//            "categories" => new ArrayCollection(array(
//                (new Category()),
//                (new Category()),
//                (new Category()),
//            )),
//            'template' => 'FitbaseWeeklytaskBundle:Block:weeklytask_collection.html.twig',
//        ));
//
//        $block = new WeeklytaskCollectionBlockService($this->name,
//            $this->container()->get('templating'), $this->objectManager, $this->serviceUser);
//
//        $result = $block->execute($blockContext, new Response());
//
//        $this->assertTrue($result instanceof Response);
//        $this->assertEquals($result->getStatusCode(), 200);
//    }
}