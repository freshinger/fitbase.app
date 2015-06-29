<?php

namespace Fitbase\Bundle\CompanyBundle\Tests\Entity;


use Application\Sonata\PageBundle\Entity\Site;
use Fitbase\Bundle\CompanyBundle\Entity\Company;
use Fitbase\Bundle\FitbaseBundle\Tests\FitbaseTestAbstract;

class CompanyTest extends FitbaseTestAbstract
{
    public function testGetSiteShouldReturnParentSite()
    {
        $site1 = new Site();
        $site1->setName('site1');

        $site2 = new Site();
        $site2->setName('site2');

        $parent = (new Company())
            ->setSite($site1);

        $child = (new Company())
            ->setSite($site2)
            ->setParent($parent);

        $this->assertEquals($child->getSite(), $parent->getSite());
    }

} 