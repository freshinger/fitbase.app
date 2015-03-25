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

class LoadPageDefaultData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
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
        if (($site = $this->getReference('default'))) {

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
            $header->setName('Header');


            $global->addBlocks($headerCompany = $blockInteractor->createNewContainer(array(
                'enabled' => true,
                'page' => $global,
                'code' => 'header-company',
            )));
            $headerCompany->setPosition(2);

            $header->addChildren($headerCompany);

            $headerCompany->setName('Header (Company)');
            $headerCompany->setPosition(1);
            $headerCompany->addChildren($blockCompany = $blockManager->create());

            $blockCompany->setName('Header Block (Company)');
            $blockCompany->setType('fitbase.block.header_company');
            $blockCompany->setPosition(1);
            $blockCompany->setEnabled(true);
            $blockCompany->setPage($global);


            $global->addBlocks($headerTop = $blockInteractor->createNewContainer(array(
                'enabled' => true,
                'page' => $global,
                'code' => 'header-top',
            ), function ($container) {
                $container->setSetting('layout', '<div class="pull-right">{{ CONTENT }}</div>');
            }));

            $headerTop->setPosition(1);

            $header->addChildren($headerTop);
            $headerTop->addChildren($account = $blockManager->create());

            $account->setType('sonata.user.block.account');
            $account->setPosition(2);
            $account->setEnabled(true);
            $account->setPage($global);


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

            if (($homepage = $this->createHomePage($site))) {
                if (($dashboard = $this->createPageWeeklytask($site, $homepage, "Infoeinheiten", "Infoeinheiten - Online - Rückenschule", ""))) {
                    $this->addReference('online-rueckenschule-wochenaufgaben', $dashboard);
                }

                if (($dashboard = $this->createPageProfile($site, $homepage, "Profil", "Profil - Online - Rückenschule", ""))) {
                    $this->addReference('online-rueckenschule-profil', $dashboard);
                }

                if (($questions = $this->createPage($site, $homepage, "Häufige Fragen", "Häufige Fragen - Online - Rückenschule", "haeufige-fragen"))) {
                    $this->addReference('online-rueckenschule-questions', $questions);
                }

                if (($questions = $this->createPage($site, $homepage, "Abmelden", "Abmelden - Online - Rückenschule", "abmelden"))) {
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

            $global->addBlocks($footerCompany = $blockInteractor->createNewContainer(array(
                'enabled' => true,
                'page' => $global,
                'code' => 'footer-company',
            )));
            $headerCompany->setPosition(2);

            $footer->addChildren($footerCompany);

            $footerCompany->setName('Footer (Company)');
            $footerCompany->setPosition(1);
            $footerCompany->addChildren($blockCompany = $blockManager->create());

            $blockCompany->setName('Footer Block (Company)');
            $blockCompany->setType('fitbase.block.footer_company');
            $blockCompany->setPosition(1);
            $blockCompany->setEnabled(true);
            $blockCompany->setPage($global);

            $pageManager->save($global);
        }
    }


    /**
     * @param SiteInterface $site
     */
    public function createHomePage(SiteInterface $site)
    {
        $pageManager = $this->getPageManager();
        $blockManager = $this->getBlockManager();
        $blockInteractor = $this->getBlockInteractor();

        $this->addReference('page-homepage', $homepage = $pageManager->create());
        $homepage->setSlug('/');
        $homepage->setUrl('/');
        $homepage->setName('Dashboard');
        $homepage->setTitle('Dashboard');
        $homepage->setEnabled(true);
        $homepage->setDecorate(0);
        $homepage->setRequestMethod('GET|POST|HEAD|DELETE|PUT');
        $homepage->setTemplateCode('default');
        $homepage->setRouteName(PageInterface::PAGE_ROUTE_CMS_NAME);
        $homepage->setSite($site);

        $pageManager->save($homepage);

        // CREATE A HEADER BLOCK
        $homepage->addBlocks($contentTop = $blockInteractor->createNewContainer(array(
            'enabled' => true,
            'page' => $homepage,
            'code' => 'content_top',
        )));

        $contentTop->setName('The container top container');

        $blockManager->save($contentTop);

        $homepage->addBlocks($content = $blockInteractor->createNewContainer(array(
            'enabled' => true,
            'page' => $homepage,
            'code' => 'content',
        )));
        $content->setName('The content container');
        $blockManager->save($content);

        // Add media gallery block
        $content->addChildren($gallery = $blockManager->create());
        $gallery->setType('fitbase.block.dashboard');
//        $gallery->setSetting('galleryId', $this->getReference('media-gallery')->getId());
        $gallery->setSetting('context', 'default');
//        $gallery->setSetting('format', 'big');
        $gallery->setPosition(1);
        $gallery->setEnabled(true);
        $gallery->setPage($homepage);
//
//        // Add recent products block
//        $content->addChildren($newProductsBlock = $blockManager->create());
//        $newProductsBlock->setType('sonata.product.block.recent_products');
//        $newProductsBlock->setSetting('number', 4);
//        $newProductsBlock->setSetting('title', 'New products');
//        $newProductsBlock->setPosition(2);
//        $newProductsBlock->setEnabled(true);
//        $newProductsBlock->setPage($homepage);

//        // Add homepage bottom container
//        $homepage->addBlocks($bottom = $blockInteractor->createNewContainer(array(
//            'enabled' => true,
//            'page' => $homepage,
//            'code' => 'content_bottom',
//        ), function ($container) {
//            $container->setSetting('layout', '{{ CONTENT }}');
//        }));
//        $bottom->setName('The bottom content container');
//
//        // Add homepage newsletter container
//        $bottom->addChildren($bottomNewsletter = $blockInteractor->createNewContainer(array(
//            'enabled' => true,
//            'page' => $homepage,
//            'code' => 'bottom_newsletter',
//        ), function ($container) {
//            $container->setSetting('layout', '<div class="block-newsletter col-sm-6 well">{{ CONTENT }}</div>');
//        }));
//        $bottomNewsletter->setName('The bottom newsetter container');
//        $bottomNewsletter->addChildren($newsletter = $blockManager->create());
//        $newsletter->setType('sonata.demo.block.newsletter');
//        $newsletter->setPosition(1);
//        $newsletter->setEnabled(true);
//        $newsletter->setPage($homepage);
//
//        // Add homepage embed tweet container
//        $bottom->addChildren($bottomEmbed = $blockInteractor->createNewContainer(array(
//            'enabled' => true,
//            'page' => $homepage,
//            'code' => 'bottom_embed',
//        ), function ($container) {
//            $container->setSetting('layout', '<div class="col-sm-6">{{ CONTENT }}</div>');
//        }));
//        $bottomEmbed->setName('The bottom embedded tweet container');
//        $bottomEmbed->addChildren($embedded = $blockManager->create());
//        $embedded->setType('sonata.seo.block.twitter.embed');
//        $embedded->setPosition(1);
//        $embedded->setEnabled(true);
//        $embedded->setSetting('tweet', "https://twitter.com/dunglas/statuses/438337742565826560");
//        $embedded->setSetting('lang', "en");
//        $embedded->setPage($homepage);

        $pageManager->save($homepage);

        return $homepage;
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
     * Create Dashboard with gamification block
     * @param $site
     * @param $parent
     * @param $name
     * @param $title
     * @param $slug
     * @return null|object
     */
    protected function createDashboard($site, $parent, $name, $title, $slug)
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

                $page->addBlocks($content = $this->getBlockInteractor()->createNewContainer(array(
                    'enabled' => true,
                    'page' => $page,
                    'code' => 'content',
                )));
                $content->setType('fitbase.block.dashboard_gamification');


                $pageManager->save($page);

                return $page;
            }
        }
        return null;
    }


    /**
     * Create page with weeklytask block
     * @param $site
     * @param $parent
     * @param $name
     * @param $title
     * @param $slug
     * @return null|object
     */
    protected function createPageWeeklytask($site, $parent, $name, $title, $slug)
    {
        if (($pageManager = $this->getPageManager())) {

            if (($page = $pageManager->create())) {

                $page->setName($name);
                $page->setTitle($title);
                $page->setSlug($slug);
                $page->setUrl("/" . strtolower($slug));
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

                $page->addBlocks($content = $this->getBlockInteractor()->createNewContainer(array(
                    'enabled' => true,
                    'page' => $page,
                    'code' => 'content',
                )));
                $content->setType('fitbase.block.dashboard_weeklytask');


                $pageManager->save($page);

                return $page;
            }
        }
        return null;
    }

    /**
     * Create page with weeklytask block
     * @param $site
     * @param $parent
     * @param $name
     * @param $title
     * @param $slug
     * @return null|object
     */
    protected function createPageProfile($site, $parent, $name, $title, $slug)
    {
        if (($pageManager = $this->getPageManager())) {
            $blockManager = $this->getBlockManager();

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

                $page->addBlocks($content = $this->getBlockInteractor()->createNewContainer(array(
                    'enabled' => true,
                    'page' => $page,
                    'code' => 'content',
                )));

                $content->addChildren($reminder = $blockManager->create());

                $reminder->setType('fitbase.block.reminder.settings');
                $reminder->setPosition(1);
                $reminder->setEnabled(true);
                $reminder->setPage($page);

                $content->addChildren($profile = $blockManager->create());

                $profile->setType('fitbase.block.dashboard_profile');
                $profile->setPosition(2);
                $profile->setEnabled(true);
                $profile->setPage($page);


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
