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
        if (($site = $this->getReference('online-rueckenschule'))) {
            $pageManager = $this->getPageManager();
            $blockManager = $this->getBlockManager();
            $blockInteractor = $this->getBlockInteractor();


            $global = $pageManager->create();
            $global->setName('global');
            $global->setRouteName('_page_internal_global');
            $global->setSite($site);
            $pageManager->save($global);


            // CREATE A HEADER BLOCK
            $global->addBlocks($header = $blockInteractor->createNewContainer(array(
                'enabled' => true,
                'page' => $global,
                'code' => 'header',
            )));
            $header->setName('The header container');

            $global->addBlocks($headerMenu = $blockInteractor->createNewContainer(array(
                'enabled' => true,
                'page' => $global,
                'code' => 'header-menu',
            )));
            $headerMenu->setPosition(2);

            $header->addChildren($headerMenu);

            $headerMenu->setName('The header menu container');
            $headerMenu->setPosition(3);
            $headerMenu->addChildren($menu = $blockManager->create());

            $menu->setType('sonata.block.service.menu');
            $menu->setSetting('menu_name', "FitbaseFitbaseBundle:Builder:mainMenu");
            $menu->setSetting('safe_labels', true);
            $menu->setPosition(3);
            $menu->setEnabled(true);
            $menu->setPage($global);


            if (($dashboard = $this->createPage($site, $global, "Dashboard", "Dashboard - Online - Rückenschule", ""))) {
                $this->addReference('online-rueckenschule-dashboard', $dashboard);


                if (($questions = $this->createPage($site, $global, "Häufige Fragen", "Häufige Fragen - Online - Rückenschule", "haeufige-fragen"))) {
                    $this->addReference('online-rueckenschule-questions', $questions);
                }

                if (($questions = $this->createPage($site, $global, "Abmelden", "Abmelden - Online - Rückenschule", "abmelden"))) {
                    $this->addReference('online-rueckenschule-abmelden', $questions);
                }
            }


            $global->addBlocks($footer = $blockInteractor->createNewContainer(array(
                'enabled' => true,
                'page' => $global,
                'code' => 'footer'
            ), function ($container) {
                $container->setSetting('layout', '<div class="row page-footer well">{{ CONTENT }}</div>');
            }));

            $footer->setName('The footer container');
            // Footer : add 3 children block containers (left, center, right)
            $footer->addChildren($footerLeft = $blockInteractor->createNewContainer(array(
                'enabled' => true,
                'page' => $global,
                'code' => 'content'
            ), function ($container) {
                $container->setSetting('layout', '<div class="col-sm-3">{{ CONTENT }}</div>');
            }));

            $footer->addChildren($footerLinksLeft = $blockInteractor->createNewContainer(array(
                'enabled' => true,
                'page' => $global,
                'code' => 'content',
            ), function ($container) {
                $container->setSetting('layout', '<div class="col-sm-2 col-sm-offset-3">{{ CONTENT }}</div>');
            }));

            $footer->addChildren($footerLinksCenter = $blockInteractor->createNewContainer(array(
                'enabled' => true,
                'page' => $global,
                'code' => 'content'
            ), function ($container) {
                $container->setSetting('layout', '<div class="col-sm-2">{{ CONTENT }}</div>');
            }));

            $footer->addChildren($footerLinksRight = $blockInteractor->createNewContainer(array(
                'enabled' => true,
                'page' => $global,
                'code' => 'content'
            ), function ($container) {
                $container->setSetting('layout', '<div class="col-sm-2">{{ CONTENT }}</div>');
            }));

            // Footer left: add a simple text block
            $footerLeft->addChildren($text = $blockManager->create());

            $text->setType('sonata.block.service.text');
            $text->setSetting('content', <<<CONTENT
<h2>Fitbase</h2>
<p><a href="http://twitter.com/fitbase" target="_blank">Follow Fitbase on Twitter</a></p>
CONTENT
            );

            $text->setPosition(1);
            $text->setEnabled(true);
            $text->setPage($global);

            // Footer left links
            $footerLinksLeft->addChildren($text = $blockManager->create());

            $text->setType('sonata.block.service.text');
            $text->setSetting('content', <<<CONTENT
<h4>PRODUCTS</h4>
<ul class="links">
    <li><a href="http://fitbase.de">Fitbase</a></li>
    <li><a href="http://online-rueckenschule.de">Online-Rückenschule</a></li>
    <li><a href="http://officephysio.de">Officephysio</a></li>
</ul>
CONTENT
            );

            $text->setPosition(1);
            $text->setEnabled(true);
            $text->setPage($global);

            // Footer middle links
            $footerLinksCenter->addChildren($text = $blockManager->create());

            $text->setType('sonata.block.service.text');
            $text->setSetting('content', <<<CONTENT
<h4>ABOUT</h4>
<ul class="links">
    <li><a href="/about" target="_blank">About Fitbase</a></li>
    <li><a href="/legal-notes">Legal notes</a></li>
    <li><a href="/terms-and-conditions">Terms</a></li>
</ul>
CONTENT
            );

            $text->setPosition(1);
            $text->setEnabled(true);
            $text->setPage($global);

            // Footer right links
            $footerLinksRight->addChildren($text = $blockManager->create());

            $text->setType('sonata.block.service.text');
            $text->setSetting('content', <<<CONTENT
<h4>COMMUNITY</h4>
<ul class="links">
    <li><a href="/blog">Blog</a></li>
    <li><a href="/contact-us">Contact us</a></li>
</ul>
CONTENT
            );

            $text->setPosition(1);
            $text->setEnabled(true);
            $text->setPage($global);

            $pageManager->save($global);
        }
    }


    /**
     * Create page
     * @param $site
     * @return null|object
     */
    public function createPage($site, $parent, $name, $title, $slug)
    {
        if (($pageManager = $this->getPageManager())) {

            if (($page = $pageManager->create())) {

                $page->setName($name);
                $page->setTitle($title);
                $page->setSlug($slug);
                $page->setUrl("/$slug");
                $page->setCreatedAt(new \DateTime("now"));
                $page->setUpdatedAt(new \DateTime("now"));
                $page->setRouteName("page_slug");
                $page->setType("sonata.page.service.default");
                $page->setRequestMethod("GET|POST|HEAD|DELETE|PUT");
                $page->setParent($parent);
                $page->setTemplateCode("default");
                $page->setEdited(1);
                $page->setEnabled(1);
                $page->setPosition(1);
                $page->setDecorate(1);
                $page->setSite($site);

                $pageManager->save($page);

                return $page;
            }
        }
        return null;
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
