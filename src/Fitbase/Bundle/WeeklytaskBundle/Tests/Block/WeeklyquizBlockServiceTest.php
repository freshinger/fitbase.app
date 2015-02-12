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
use Fitbase\Bundle\WeeklytaskBundle\Block\WeeklyquizBlockService;
use Fitbase\Bundle\WeeklytaskBundle\Block\WeeklytaskBlockService;
use Fitbase\Bundle\WeeklytaskBundle\Block\WeeklytaskCollectionBlockService;
use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklyquiz;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskReminderEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Subscriber\WeeklytaskUserSubscriber;
use Sonata\BlockBundle\Block\BlockContext;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;

class WeeklyquizBlockServiceTest extends WebTestCase
{
    protected $name;
    protected $templating;
    protected $serviceUser;
    protected $objectManager;

    public function setUp()
    {
        date_default_timezone_set('Europe/Berlin');

        $this->name = 'Quiz test block';


        $this->eventDispatcher = $this->getMock('EventDispatcher', array(
            'dispatch',
        ));
        $this->eventDispatcher->expects($this->any())
            ->method('dispatch')
            ->will($this->returnValue(true));


        $this->templating = $this->getMock('\Symfony\Bundle\FrameworkBundle\Templating\EngineInterface', array(
            'renderResponse', 'render', 'exists', 'supports'
        ));
        $this->templating->expects($this->any())
            ->method('renderResponse')
            ->will($this->returnValue(new Response()));
        $this->templating->expects($this->any())
            ->method('render')
            ->will($this->returnValue(true));
        $this->templating->expects($this->any())
            ->method('exists')
            ->will($this->returnValue(true));
        $this->templating->expects($this->any())
            ->method('supports')
            ->will($this->returnValue(true));
    }

    protected function container(array $options = array(), array $server = array())
    {
        static::bootKernel($options);
        return static::$kernel->getContainer();
    }


    /**
     * Check that block calculate a html
     * for user
     */
    public function testBlockShouldReturnResponseWithCode200()
    {
        $block = new WeeklyquizBlockService($this->name, $this->container()->get('templating'), $this->eventDispatcher);

        $result = $block->execute(new BlockContext(new Block(), array(
            "weeklyquizUser" => (new WeeklyquizUser())->setQuiz(
                (new Weeklyquiz())
                    ->setName("Test name")
                    ->setDescription("Test name description")
            ),
            'template' => 'FitbaseWeeklytaskBundle:Block:weeklyquiz.html.twig',
        )), new Response());

        $this->assertTrue($result instanceof Response);
        $this->assertEquals($result->getStatusCode(), 200);
    }

    /**
     * Check that html block has a
     * correct text and image
     */
    public function testBlockShouldHaveNameAndContent()
    {
        $codeCheck = null;
        $eventCheck = null;

        $this->eventDispatcher->expects($this->any())
            ->method('dispatch')
            ->will($this->returnCallback(function ($code, $event) use (&$codeCheck, &$eventCheck) {
                $codeCheck = $code;
                $eventCheck = $event;
            }));

        $block = new WeeklyquizBlockService($this->name, $this->container()->get('templating'), $this->eventDispatcher);

        $result = $block->execute(new BlockContext(new Block(), array(
            "weeklyquizUser" => (new WeeklyquizUser())->setQuiz(
                (new Weeklyquiz())
                    ->setName("Test name")
                    ->setDescription("Test name description")
            ),
            'template' => 'FitbaseWeeklytaskBundle:Block:weeklyquiz.html.twig',
        )), new Response());

        $crawler = new Crawler(null, null);
        $crawler->addContent($result->getContent());
        $this->assertGreaterThan(0, $crawler->filter("img")->count());
        $this->assertGreaterThan(0, $crawler->filter("div:contains(Herzlich willkommen zu Ihrem Quiz)")->count());
    }
}