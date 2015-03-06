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
use Fitbase\Bundle\CompanyBundle\Entity\Company;
use Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory;
use Fitbase\Bundle\FitbaseBundle\Tests\FitbaseTestAbstract;
use Fitbase\Bundle\QuestionnaireBundle\Block\Dashboard\StatisticAssessmentBlock;
use Sonata\BlockBundle\Block\BlockContext;
use Sonata\BlockBundle\Model\Block;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;

class StatisticAssessmentBlockTest extends FitbaseTestAbstract
{
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
        $category1 = (new Category());
        $category1->setSlug('stress');

        $category2 = (new Category());
        $category2->setSlug('augen');

        $blockContext = new BlockContext(new Block(), array(
            'company' => (new Company())
                ->addCategory(
                    (new CompanyCategory())
                        ->setCategory($category1)
                )
                ->addCategory(
                    (new CompanyCategory())
                        ->setCategory($category2)
                ),
            'template' => 'FitbaseQuestionnaireBundle:Block:dashboard/statistic/assessment.html.twig',
        ));

        $block = new StatisticAssessmentBlock('name', array('ROLE_COMPANY'), $this->container()->get('templating'),
            $this->securityContext, $this->serviceUser);

        $result = $block->execute($blockContext, new Response());

        $this->assertTrue($result instanceof Response);
        $this->assertEquals($result->getStatusCode(), 200);
    }


    public function testBlockShouldRenderAnImage()
    {
        $category1 = (new Category());
        $category1->setSlug('stress');

        $category2 = (new Category());
        $category2->setSlug('augen');

        $blockContext = new BlockContext(new Block(), array(
            'company' => (new Company())
                ->addCategory(
                    (new CompanyCategory())
                        ->setCategory($category1)
                )
                ->addCategory(
                    (new CompanyCategory())
                        ->setCategory($category2)
                ),
            'template' => 'FitbaseQuestionnaireBundle:Block:dashboard/statistic/assessment.html.twig',
        ));

        $block = new StatisticAssessmentBlock('name', array('ROLE_COMPANY'), $this->container()->get('templating'),
            $this->securityContext, $this->serviceUser);

        $result = $block->execute($blockContext, new Response());

        $crawler = new Crawler(null, null);
        $crawler->addContent($result->getContent());

        $this->assertEquals($crawler->filter("svg")->count(), 1);
    }
}