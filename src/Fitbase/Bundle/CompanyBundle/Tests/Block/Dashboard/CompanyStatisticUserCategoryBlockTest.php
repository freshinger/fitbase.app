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
use Fitbase\Bundle\CompanyBundle\Block\Dashboard\CompanyStatisticUserCategoryBlock;
use Fitbase\Bundle\CompanyBundle\Block\Dashboard\StatisticUserCategoryBlock;
use Fitbase\Bundle\CompanyBundle\Entity\Company;
use Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory;
use Fitbase\Bundle\FitbaseBundle\Tests\FitbaseTestAbstract;
use Sonata\BlockBundle\Block\BlockContext;
use Sonata\BlockBundle\Model\Block;
use Symfony\Component\HttpFoundation\Response;

class CompanyStatisticUserCategoryBlockTest extends FitbaseTestAbstract
{
    public function test_blockShouldReturnStatus200()
    {
        $company = $this->getMock('\Fitbase\Bundle\CompanyBundle\Service\ServiceCompanyInterface', array('current'));
        $company->expects($this->any())->method('current')
            ->will($this->returnValue(
                (new Company())
                    ->setUserLimit(100)
                    ->addUser((new User()))
                    ->addUser((new User()))
                    ->addUser((new User()))
                    ->addUser((new User()))
                    ->addUser((new User()))
                    ->addUser((new User()))
                    ->addUser((new User()))
                    ->addUser((new User()))
            ));


        $name = 'name';
        $roles = array('ROLE_FITBASE_USER');
        $templating = $this->container()->get('templating');
        $security = $this->getSecurityContainer();

        $block = new CompanyStatisticUserCategoryBlock($name, $roles, $templating, $security);
        $block->setServiceCompany($company);

        $result = $block->execute(new BlockContext(new Block(), array(
            'slug' => 'stress',
            'company' => (new Company()),
            'template_default' => 'FitbaseCompanyBundle:Block:Dashboard/UserCategory.html.twig',
            'template_locked' => 'FitbaseCompanyBundle:Block:Dashboard/UserCategoryLocked.html.twig',
        )), new Response());

        $this->assertTrue($result instanceof Response);
        $this->assertEquals($result->getStatusCode(), 200);
    }

    /**
     * Check that block html
     * have a svg-image
     *
     */
    public function test_blockShouldHaveSVGImage()
    {
        $company = $this->getMock('\Fitbase\Bundle\CompanyBundle\Service\ServiceCompanyInterface', array('current'));
        $company->expects($this->any())->method('current')
            ->will($this->returnValue(
                (new Company())
                    ->setUserLimit(1)
                    ->addCategory(
                        (new CompanyCategory())
                            ->setCategory(
                                (new Category())
                                    ->setSlug('stress')
                            )
                    )
                    ->addCategory(
                        (new CompanyCategory())
                            ->setCategory(
                                (new Category())
                                    ->setSlug('augen')
                            )
                    )
                    ->addUser((new User()))
                    ->addUser((new User()))
                    ->addUser((new User()))
                    ->addUser((new User()))
                    ->addUser((new User()))
                    ->addUser((new User()))
                    ->addUser((new User()))
                    ->addUser((new User()))
            ));


        $name = 'name';
        $roles = array('ROLE_FITBASE_USER');
        $templating = $this->container()->get('templating');
        $security = $this->getSecurityContainer();

        $block = new CompanyStatisticUserCategoryBlock($name, $roles, $templating, $security);
        $block->setServiceCompany($company);

        $result = $block->execute(new BlockContext(new Block(), array(
            'slug' => 'stress',
            'template_default' => 'FitbaseCompanyBundle:Block:Dashboard/UserCategory.html.twig',
            'template_locked' => 'FitbaseCompanyBundle:Block:Dashboard/UserCategoryLocked.html.twig',
        )), new Response());


        \phpQuery::newDocumentHTML($result->getContent());

        $this->assertEquals(count(pq('svg')), 1);
    }


    public function testBlockShouldRespectUserLimit()
    {
        $company = $this->getMock('\Fitbase\Bundle\CompanyBundle\Service\ServiceCompanyInterface', array('current'));
        $company->expects($this->any())->method('current')
            ->will($this->returnValue(
                (new Company())
                    ->setUserLimit(100)
                    ->addUser((new User()))
                    ->addUser((new User()))
                    ->addUser((new User()))
                    ->addUser((new User()))
                    ->addUser((new User()))
                    ->addUser((new User()))
                    ->addUser((new User()))
                    ->addUser((new User()))
            ));

        $name = 'name';
        $roles = array('ROLE_FITBASE_USER');
        $templating = $this->container()->get('templating');
        $security = $this->getSecurityContainer();

        $block = new CompanyStatisticUserCategoryBlock($name, $roles, $templating, $security);
        $block->setServiceCompany($company);

        $result = $block->execute(new BlockContext(new Block(), array(
            'slug' => 'stress',
            'template_default' => 'FitbaseCompanyBundle:Block:Dashboard/UserCategory.html.twig',
            'template_locked' => 'FitbaseCompanyBundle:Block:Dashboard/UserCategoryLocked.html.twig',
        )), new Response());

        \phpQuery::newDocumentHTML($result->getContent());

        $this->assertEquals(pq(pq('img')->get(0))->attr('src'), '/image/dashboard_ruecken.png');
    }
}