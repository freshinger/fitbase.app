<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\Bundle\FitbaseBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use Sonata\PageBundle\Model\SiteInterface;
use Sonata\PageBundle\Model\PageInterface;

use Symfony\Cmf\Bundle\RoutingBundle\Tests\Unit\Doctrine\Orm\ContentRepositoryTest;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadPageOnlineRueckenschuleData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;

    public function getOrder()
    {
        return 5;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Load pages for online-rueckenschule
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $pageManager = $this->getPageManager();

        // Create dashboard or default page
        $dashboard = $pageManager->create();
        $dashboard->setCreatedAt(new \DateTime("now"));
        $dashboard->setUpdatedAt(new \DateTime("now"));
        $dashboard->setRouteName("page_slug");
        $dashboard->setName("Dashboard");
        $dashboard->setTitle("Dashboard - Online - Rückenschule");
        $dashboard->setSlug("/");
        $dashboard->setUrl("/");
        $dashboard->setRequestMethod("GET|POST|HEAD|DELETE|PUT");
        $dashboard->setTemplateCode("default");
        $dashboard->setEnabled(1);
        $dashboard->setPosition(1);
        $dashboard->setDecorate(1);
        $dashboard->setSite($this->getReference('online-rueckenschule'));
        $pageManager->save($dashboard);

        $this->addReference('online-rueckenschule-dashboard', $dashboard);

        $uebungen = $pageManager->create();
        $uebungen->setCreatedAt(new \DateTime("now"));
        $uebungen->setUpdatedAt(new \DateTime("now"));
        $uebungen->setRouteName("page_slug");
        $uebungen->setType("sonata.page.service.default");
        $uebungen->setName("Übungen");
        $uebungen->setTitle("Übungen - Online - Rückenschule");
        $uebungen->setSlug("uebungen");
        $uebungen->setUrl("/uebungen");
        $uebungen->setRequestMethod("GET|POST|HEAD|DELETE|PUT");
        $uebungen->setParent($dashboard);
        $uebungen->setTemplateCode("default");
        $uebungen->setEdited(1);
        $uebungen->setEnabled(1);
        $uebungen->setPosition(1);
        $uebungen->setDecorate(1);
        $uebungen->setSite($this->getReference('online-rueckenschule'));
        $pageManager->save($uebungen);

        $this->addReference('online-rueckenschule-uebungen', $uebungen);


        $wochanaufgaben = $pageManager->create();
        $wochanaufgaben->setCreatedAt(new \DateTime("now"));
        $wochanaufgaben->setUpdatedAt(new \DateTime("now"));
        $wochanaufgaben->setRouteName("page_slug");
        $wochanaufgaben->setType("sonata.page.service.default");
        $wochanaufgaben->setName("Wochanaufgaben");
        $wochanaufgaben->setTitle("Wochanaufgaben - Online - Rückenschule");
        $wochanaufgaben->setSlug("wochenaufgaben");
        $wochanaufgaben->setUrl("/wochenaufgaben");
        $wochanaufgaben->setRequestMethod("GET|POST|HEAD|DELETE|PUT");
        $wochanaufgaben->setParent($dashboard);
        $wochanaufgaben->setTemplateCode("default");
        $wochanaufgaben->setEdited(1);
        $wochanaufgaben->setEnabled(1);
        $wochanaufgaben->setPosition(1);
        $wochanaufgaben->setDecorate(1);
        $wochanaufgaben->setSite($this->getReference('online-rueckenschule'));

        $pageManager->save($wochanaufgaben);

        $this->addReference('online-rueckenschule-wochanaufgaben', $wochanaufgaben);

    }


    /**
     * @return \Sonata\PageBundle\Model\SiteManagerInterface
     */
    public function getSiteManager()
    {
        return $this->container->get('sonata.page.manager.site');
    }

    /**
     * @return \Sonata\PageBundle\Model\PageManagerInterface
     */
    public function getPageManager()
    {
        return $this->container->get('sonata.page.manager.page');
    }

    /**
     * @return \Sonata\BlockBundle\Model\BlockManagerInterface
     */
    public function getBlockManager()
    {
        return $this->container->get('sonata.page.manager.block');
    }

    /**
     * @return \Faker\Generator
     */
    public function getFaker()
    {
        return $this->container->get('faker.generator');
    }

    /**
     * @return \Sonata\PageBundle\Entity\BlockInteractor
     */
    public function getBlockInteractor()
    {
        return $this->container->get('sonata.page.block_interactor');
    }
}
