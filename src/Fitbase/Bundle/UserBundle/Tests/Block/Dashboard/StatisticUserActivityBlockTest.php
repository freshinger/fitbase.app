<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 05/03/15
 * Time: 16:02
 */
namespace Fitbase\Bundle\UserBundle\Tests\Block\Dashboard;


use Fitbase\Bundle\CompanyBundle\Entity\Company;
use Fitbase\Bundle\FitbaseBundle\Tests\FitbaseTestAbstract;
use Fitbase\Bundle\UserBundle\Block\Dashboard\StatisticUserActivityBlock;
use Sonata\BlockBundle\Block\BlockContext;
use Sonata\BlockBundle\Model\Block;
use Symfony\Component\HttpFoundation\Response;

class StatisticUserActivityBlockTest extends FitbaseTestAbstract
{
    public function test_blockShouldReturnStatus200()
    {
        $block = new StatisticUserActivityBlock('name', array('ROLE_USER'), $this->container()->get('templating'), $this->getSecurityContainer());

        $result = $block->execute(new BlockContext(new Block(), array(
            "company" => (new Company()),
            'template' => 'FitbaseUserBundle:Block:Dashboard/statistic/user_activity.html.twig',
        )), new Response());

        $this->assertTrue($result instanceof Response);
        $this->assertEquals($result->getStatusCode(), 200);
    }

} 