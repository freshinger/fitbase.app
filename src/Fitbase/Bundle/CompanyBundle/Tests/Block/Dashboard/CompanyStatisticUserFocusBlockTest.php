<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 05/03/15
 * Time: 16:02
 */
namespace Fitbase\Bundle\CompanyBundle\Tests\Block\Dashboard;


use Application\Sonata\ClassificationBundle\Entity\Category;
use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\CompanyBundle\Block\Dashboard\CompanyStatisticUserFocusBlock;
use Fitbase\Bundle\CompanyBundle\Entity\Company;
use Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory;
use Fitbase\Bundle\FitbaseBundle\Tests\FitbaseTestAbstract;
use Sonata\BlockBundle\Block\BlockContext;
use Sonata\BlockBundle\Model\Block;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;

class CompanyStatisticUserFocusBlockTest extends FitbaseTestAbstract
{
//
//    protected $company;
//
//    public function setUp()
//    {
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
//    public function test_blockShouldReturnStatus200()
//    {
//        $name = 'name';
//        $roles = array('ROLE_FITBASE_USER');
//        $templating = $this->container()->get('templating');
//        $security = $this->getSecurityContainer();
//
//
//        $block = new CompanyStatisticUserFocusBlock($name, $roles, $templating, $security);
//        $block->setServiceCompany($this->company);
//
//        $result = $block->execute(new BlockContext(new Block(), array(
//            "company" => (new Company()),
//            'template_default' => 'FitbaseCompanyBundle:Block:Dashboard/UserFocus.html.twig',
//            'template_locked' => 'FitbaseCompanyBundle:Block:Dashboard/UserFocusLocked.html.twig',
//        )), new Response());
//
//        $this->assertTrue($result instanceof Response);
//        $this->assertEquals($result->getStatusCode(), 200);
//    }
//
//    /**
//     * Check that block return
//     * a svg image
//     *
//     */
//    public function test_blockShouldHaveSVGImage()
//    {
//        $name = 'name';
//        $roles = array('ROLE_FITBASE_USER');
//        $templating = $this->container()->get('templating');
//        $security = $this->getSecurityContainer();
//
//        $block = new CompanyStatisticUserFocusBlock($name, $roles, $templating, $security);
//        $block->setServiceCompany($this->company);
//
//        $category1 = (new Category());
//        $category1->setName('stress');
//        $category1->setSlug('stress');
//
//        $category2 = (new Category());
//        $category2->setName('augen');
//        $category2->setSlug('augen');
//
//        $result = $block->execute(new BlockContext(new Block(), array(
//            'slug' => 'stress',
//            'template_default' => 'FitbaseCompanyBundle:Block:Dashboard/UserFocus.html.twig',
//            'template_locked' => 'FitbaseCompanyBundle:Block:Dashboard/UserFocusLocked.html.twig',
//        )), new Response());
//
//        $crawler = new Crawler(null, null);
//        $crawler->addContent($result->getContent());
//
//        $this->assertEquals(1, $crawler->filter("svg")->count());
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
//        $block = new CompanyStatisticUserFocusBlock($name, $roles, $templating, $security);
//        $block->setServiceCompany($company);
//
//        $result = $block->execute(new BlockContext(new Block(), array(
//            'slug' => 'stress',
//            'template_default' => 'FitbaseCompanyBundle:Block:Dashboard/UserFocus.html.twig',
//            'template_locked' => 'FitbaseCompanyBundle:Block:Dashboard/UserFocusLocked.html.twig',
//        )), new Response());
//
//        \phpQuery::newDocumentHTML($result->getContent());
//
//        $this->assertEquals(pq(pq('img')->get(0))->attr('src'), '/image/dashboard_focus.png');
//    }
} 