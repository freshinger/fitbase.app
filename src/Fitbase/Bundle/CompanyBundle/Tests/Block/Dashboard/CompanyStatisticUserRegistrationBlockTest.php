<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 05/03/15
 * Time: 16:02
 */
namespace Fitbase\Bundle\CompanyBundle\Tests\Block\Dashboard;


use Application\Sonata\ClassificationBundle\Entity\Category;
use Fitbase\Bundle\CompanyBundle\Block\Dashboard\CompanyStatisticUserRegistrationBlock;
use Fitbase\Bundle\CompanyBundle\Block\Dashboard\StatisticUserRegistrationBlock;
use Fitbase\Bundle\CompanyBundle\Entity\Company;
use Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory;
use Fitbase\Bundle\FitbaseBundle\Tests\FitbaseTestAbstract;
use Sonata\BlockBundle\Block\BlockContext;
use Sonata\BlockBundle\Model\Block;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;

class CompanyUserRegistrationBlockTest extends FitbaseTestAbstract
{
//    public function test_blockShouldReturnStatus200()
//    {
//        $block = new CompanyStatisticUserRegistrationBlock('name', array('ROLE_FITBASE_USER'), $this->container()->get('templating'), $this->getSecurityContainer());
//
//        $result = $block->execute(new BlockContext(new Block(), array(
//            "company" => (new Company()),
//            'template' => 'FitbaseCompanyBundle:Block:Dashboard/UserRegistration.html.twig',
//        )), new Response());
//
//        $this->assertTrue($result instanceof Response);
//        $this->assertEquals($result->getStatusCode(), 200);
//    }
//
//    public function test_blockShouldHaveSVGImage()
//    {
//        $block = new CompanyStatisticUserRegistrationBlock('name', array('ROLE_FITBASE_USER'), $this->container()->get('templating'), $this->getSecurityContainer());
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
//            'company' => (new Company())
//                ->addCategory(
//                    (new CompanyCategory())
//                        ->setCategory($category1)
//                )
//                ->addCategory(
//                    (new CompanyCategory())
//                        ->setCategory($category2)
//                ),
//            'template' => 'FitbaseCompanyBundle:Block:Dashboard/UserRegistration.html.twig',
//        )), new Response());
//
//
//        $crawler = new Crawler(null, null);
//        $crawler->addContent($result->getContent());
//
//        $this->assertEquals(1, $crawler->filter("svg")->count());
//    }

} 