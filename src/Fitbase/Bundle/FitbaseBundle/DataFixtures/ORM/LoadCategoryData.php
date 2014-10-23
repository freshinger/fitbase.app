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

class LoadCategoryData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;

    public function getOrder()
    {
        return 1;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Returns the Sonata MediaManager.
     *
     * @return \Sonata\CoreBundle\Model\ManagerInterface
     */
    public function getCategoryManager()
    {
        return $this->container->get('sonata.classification.manager.category');
    }


    public function load(ObjectManager $manager)
    {
        // Travels category
        $travels = $this->getCategoryManager()->create();
        $travels->setName('Rücken');
        $travels->setSlug('ruecken');
        $travels->setDescription('Schulter und Nachen, mitlere und untere Rücken');
        $travels->setEnabled(true);
        $this->getCategoryManager()->save($travels);
        $this->setReference('category_ruecken', $travels);

        // Travels category
        $travels = $this->getCategoryManager()->create();
        $travels->setName('Augen');
        $travels->setSlug('Augen');
        $travels->setDescription('Augen Entspannung');
        $travels->setEnabled(true);
        $this->getCategoryManager()->save($travels);
        $this->setReference('category_augen', $travels);

        // Travels category
        $travels = $this->getCategoryManager()->create();
        $travels->setName('RSI');
        $travels->setSlug('rsi');
        $travels->setDescription('RSI');
        $travels->setEnabled(true);
        $this->getCategoryManager()->save($travels);
        $this->setReference('category_rsi', $travels);
    }
}