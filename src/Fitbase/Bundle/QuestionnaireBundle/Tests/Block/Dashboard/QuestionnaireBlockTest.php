<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 03/03/15
 * Time: 14:43
 */

namespace Fitbase\Bundle\QuestionnaireBundle\Tests\Block\Dashboard;


use Application\Sonata\ClassificationBundle\Entity\Category;
use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\ExerciseBundle\Block\ExerciseRandomBlockService;
use Fitbase\Bundle\ExerciseBundle\Entity\Exercise;
use Fitbase\Bundle\QuestionnaireBundle\Block\Dashboard\QuestionnaireBlock;
use Sonata\BlockBundle\Block\BlockContext;
use Sonata\BlockBundle\Model\Block;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;

class QuestionnaireBlockTest extends WebTestCase
{
    protected function container(array $options = array(), array $server = array())
    {
        static::bootKernel($options);
        return static::$kernel->getContainer();
    }

    protected $templating;
    protected $securityContext;
    protected $serviceUser;


    public function setUp()
    {
        date_default_timezone_set('Europe/Berlin');

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


        $this->securityContext = $this->getMock('\Symfony\Component\Security\Core\SecurityContextInterface', array('isGranted', 'getToken', 'setToken'));
        $this->securityContext->expects($this->any())->method('isGranted')
            ->will($this->returnValue(true));

        $this->serviceUser = $this->getMock('ServiceUser', array('current'));
        $this->serviceUser->expects($this->any())->method('current')
            ->will($this->returnValue((new User())->addRole('ROLE_COMPANY')));
    }


    public function testBlockShouldReturnResponseWithCode200()
    {
        $blockContext = new BlockContext(new Block(), array(
            'template' => 'FitbaseQuestionnaireBundle:Block:dashboard/questionnaire.html.twig',
        ));

        $block = new QuestionnaireBlock('name', array('ROLE_COMPANY'), $this->container()->get('templating'),
            $this->securityContext, $this->serviceUser);

        $result = $block->execute($blockContext, new Response());

        $this->assertTrue($result instanceof Response);
        $this->assertEquals($result->getStatusCode(), 200);
    }

    
    public function testBlockShouldRenderAnImage()
    {
        $blockContext = new BlockContext(new Block(), array(
            'template' => 'FitbaseQuestionnaireBundle:Block:dashboard/questionnaire.html.twig',
        ));

        $block = new QuestionnaireBlock('name', array('ROLE_COMPANY'), $this->container()->get('templating'),
            $this->securityContext, $this->serviceUser);

        $result = $block->execute($blockContext, new Response());

        $crawler = new Crawler(null, null);
        $crawler->addContent($result->getContent());

        $this->assertEquals($crawler->filter("img")->count(), 1);
    }
}