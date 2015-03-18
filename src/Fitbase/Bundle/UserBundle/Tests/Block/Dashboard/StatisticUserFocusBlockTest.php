<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 05/03/15
 * Time: 16:02
 */
namespace Fitbase\Bundle\UserBundle\Tests\Block\Dashboard;


use Application\Sonata\ClassificationBundle\Entity\Category;
use Fitbase\Bundle\CompanyBundle\Entity\Company;
use Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory;
use Fitbase\Bundle\FitbaseBundle\Tests\FitbaseTestAbstract;
use Fitbase\Bundle\UserBundle\Block\Dashboard\StatisticUserActivityBlock;
use Fitbase\Bundle\UserBundle\Block\Dashboard\StatisticUserFocusBlock;
use Sonata\BlockBundle\Block\BlockContext;
use Sonata\BlockBundle\Model\Block;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;

class StatisticUserFocusBlockTest extends FitbaseTestAbstract
{
    public function test_blockShouldReturnStatus200()
    {

        $block = new StatisticUserFocusBlock('name', array('ROLE_FITBASE_COMPANY'), $this->container()->get('templating'), $this->getSecurityContainer());

        $result = $block->execute(new BlockContext(new Block(), array(
            "company" => (new Company()),
            'template' => 'FitbaseUserBundle:Block:dashboard/statistic/user_focus.html.twig',
        )), new Response());

        $this->assertTrue($result instanceof Response);
        $this->assertEquals($result->getStatusCode(), 200);
    }

    /**
     * Check that block return
     * a svg image
     *
     */
    public function test_blockShouldHaveSVGImage()
    {
        $block = new StatisticUserFocusBlock('name', array('ROLE_FITBASE_COMPANY'), $this->container()->get('templating'), $this->getSecurityContainer());

        $category1 = (new Category());
        $category1->setName('stress');
        $category1->setSlug('stress');

        $category2 = (new Category());
        $category2->setName('augen');
        $category2->setSlug('augen');

        $result = $block->execute(new BlockContext(new Block(), array(
            'slug' => 'stress',
            'company' => (new Company())
                ->addCategory(
                    (new CompanyCategory())
                        ->setCategory($category1)
                )
                ->addCategory(
                    (new CompanyCategory())
                        ->setCategory($category2)
                ),
            'template' => 'FitbaseUserBundle:Block:dashboard/statistic/user_focus.html.twig',
        )), new Response());

        $crawler = new Crawler(null, null);
        $crawler->addContent($result->getContent());

        $this->assertEquals(1, $crawler->filter("svg")->count());
    }
} 