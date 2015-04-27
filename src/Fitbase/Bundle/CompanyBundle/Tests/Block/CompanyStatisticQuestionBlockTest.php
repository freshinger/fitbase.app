<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 03/03/15
 * Time: 14:43
 */

namespace Fitbase\Bundle\CompanyBundle\Tests\Block;


use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\CompanyBundle\Block\CompanyQuestionStatisticBlock;
use Fitbase\Bundle\CompanyBundle\Block\CompanyStatisticQuestionBlock;
use Fitbase\Bundle\CompanyBundle\Entity\Company;
use Fitbase\Bundle\FitbaseBundle\Tests\FitbaseTestAbstract;
use Fitbase\Bundle\QuestionnaireBundle\Block\Dashboard\QuestionnaireBlock;
use Fitbase\Bundle\QuestionnaireBundle\Block\QuestionnaireQuestionBlock;
use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireAnswer;
use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireQuestion;
use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser;
use Sonata\BlockBundle\Block\BlockContext;
use Sonata\BlockBundle\Model\Block;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;

class CompanyStatisticQuestionBlockTest extends FitbaseTestAbstract
{
//    protected $templating;
//    protected $securityContext;
//    protected $serviceUser;
//
//    public function setUp()
//    {
//        date_default_timezone_set('Europe/Berlin');
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
//
//
//        $this->securityContext = $this->getMock('\Symfony\Component\Security\Core\SecurityContextInterface', array('isGranted', 'getToken', 'setToken'));
//        $this->securityContext->expects($this->any())->method('isGranted')
//            ->will($this->returnValue(true));
//
//        $this->company = $this->getMock('\Fitbase\Bundle\CompanyBundle\Service\ServiceCompanyInterface', array('current'));
//        $this->company->expects($this->any())->method('current')
//            ->will($this->returnValue(
//                (new Company())
//                    ->addUser((new User()))
//                    ->addUser((new User()))
//                    ->addUser((new User()))
//                    ->addUser((new User()))
//                    ->addUser((new User()))
//                    ->addUser((new User()))
//                    ->addUser((new User()))
//                    ->addUser((new User()))
//            ));
//    }
//
//
//    public function testBlockShouldReturnResponseWithCode200()
//    {
//
//        $name = 'name';
//        $roles = array('ROLE_FITBASE_USER');
//        $templating = $this->container()->get('templating');
//        $security = $this->getSecurityContainer();
//
//        $block = new CompanyStatisticQuestionBlock($name, $roles, $templating, $security);
//        $block->setServiceCompany($this->company);
//
//        $blockContext = new BlockContext(new Block(), array(
//            'question' => (new QuestionnaireQuestion())
//                ->setId(12),
//            'questionnaireUser' => (new QuestionnaireUser()),
//            'template_default' => 'FitbaseCompanyBundle:Block:QuestionnaireQuestion.html.twig',
//            'template_locked' => 'FitbaseCompanyBundle:Block:QuestionnaireQuestionLocked.html.twig',
//        ));
//
//
//        $result = $block->execute($blockContext, new Response());
//
//        $this->assertTrue($result instanceof Response);
//        $this->assertEquals($result->getStatusCode(), 200);
//    }
//
//
//    public function testBlockShouldRenderAnImage()
//    {
//        $name = 'name';
//        $roles = array('ROLE_FITBASE_USER');
//        $templating = $this->container()->get('templating');
//        $security = $this->getSecurityContainer();
//
//        $block = new CompanyStatisticQuestionBlock($name, $roles, $templating, $security);
//        $block->setServiceCompany($this->company);
//
//        $blockContext = new BlockContext(new Block(), array(
//            'question' => (new QuestionnaireQuestion())
//                ->addAnswer((new QuestionnaireAnswer())),
//            'questionnaireUser' => (new QuestionnaireUser()),
//            'template_default' => 'FitbaseCompanyBundle:Block:QuestionnaireQuestion.html.twig',
//            'template_locked' => 'FitbaseCompanyBundle:Block:QuestionnaireQuestionLocked.html.twig',
//        ));
//
//        $result = $block->execute($blockContext, new Response());
//
//        $crawler = new Crawler(null, null);
//        $crawler->addContent($result->getContent());
//
//        $this->assertEquals($crawler->filter("svg")->count(), 1);
//    }
//
//
//    public function testBlockShouldRespectUserLimit()
//    {
//        $company = $this->getMock('\Fitbase\Bundle\CompanyBundle\Service\ServiceCompanyInterface', array('current'));
//        $company->expects($this->any())->method('current')
//            ->will($this->returnValue(
//                (new Company())
//                    ->setUserLimit(100)
//                    ->addUser((new User()))
//                    ->addUser((new User()))
//                    ->addUser((new User()))
//                    ->addUser((new User()))
//                    ->addUser((new User()))
//                    ->addUser((new User()))
//                    ->addUser((new User()))
//                    ->addUser((new User()))
//            ));
//
//        $name = 'name';
//        $roles = array('ROLE_FITBASE_USER');
//        $templating = $this->container()->get('templating');
//        $security = $this->getSecurityContainer();
//
//        $block = new CompanyStatisticQuestionBlock($name, $roles, $templating, $security);
//        $block->setServiceCompany($company);
//
//        $result = $block->execute(new BlockContext(new Block(), array(
//            'question' => (new QuestionnaireQuestion())
//                ->addAnswer((new QuestionnaireAnswer())),
//            'template_default' => 'FitbaseCompanyBundle:Block:QuestionnaireQuestion.html.twig',
//            'template_locked' => 'FitbaseCompanyBundle:Block:QuestionnaireQuestionLocked.html.twig',
//        )), new Response());
//
//        \phpQuery::newDocumentHTML($result->getContent());
//
//        $this->assertEquals(pq(pq('img')->get(0))->attr('src'), '/image/dashboard_question.png');
//    }
}