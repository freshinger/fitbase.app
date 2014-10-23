<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\Bundle\ExerciseBundle\DataFixtures\ORM;

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


        $travels = $this->getCategoryManager()->create();
        $travels->setName('Stress');
        $travels->setSlug('stress');
        $travels->setDescription('stress');
        $travels->setEnabled(true);
        $this->getCategoryManager()->save($travels);
        $this->setReference('category_stress', $travels);

        $travels = $this->getCategoryManager()->create();
        $travels->setName('Stress');
        $travels->setSlug('stress');
        $travels->setDescription('stress');
        $travels->setEnabled(true);
        $this->getCategoryManager()->save($travels);
        $this->setReference('category_stress', $travels);

        $travels = $this->getCategoryManager()->create();
        $travels->setName('Übersäuerung');
        $travels->setSlug('uebersäuerung');
        $travels->setDescription('uebersäuerung');
        $travels->setEnabled(true);
        $this->getCategoryManager()->save($travels);
        $this->setReference('category_uebersäuerung', $travels);

        $travels = $this->getCategoryManager()->create();
        $travels->setName('Verspannungen');
        $travels->setSlug('verspannungen');
        $travels->setDescription('verspannungen');
        $travels->setEnabled(true);
        $this->getCategoryManager()->save($travels);
        $this->setReference('category_verspannungen', $travels);

        $travels = $this->getCategoryManager()->create();
        $travels->setName('Bandscheiben');
        $travels->setSlug('bandscheiben');
        $travels->setDescription('bandscheiben');
        $travels->setEnabled(true);
        $this->getCategoryManager()->save($travels);
        $this->setReference('category_bandscheiben', $travels);

        $travels = $this->getCategoryManager()->create();
        $travels->setName('Atmung');
        $travels->setSlug('atmung');
        $travels->setDescription('atmung');
        $travels->setEnabled(true);
        $this->getCategoryManager()->save($travels);
        $this->setReference('category_atmung', $travels);

        $travels = $this->getCategoryManager()->create();
        $travels->setName('Arbeitsplatzergonomie');
        $travels->setSlug('arbeitsplatzergonomie');
        $travels->setDescription('arbeitsplatzergonomie');
        $travels->setEnabled(true);
        $this->getCategoryManager()->save($travels);
        $this->setReference('category_arbeitsplatzergonomie', $travels);

        $travels = $this->getCategoryManager()->create();
        $travels->setName('Gewohnheiten');
        $travels->setSlug('gewohnheiten');
        $travels->setDescription('gewohnheiten');
        $travels->setEnabled(true);
        $this->getCategoryManager()->save($travels);
        $this->setReference('category_gewohnheiten', $travels);

        $travels = $this->getCategoryManager()->create();
        $travels->setName('Entspannung');
        $travels->setSlug('entspannung');
        $travels->setDescription('entspannung');
        $travels->setEnabled(true);
        $this->getCategoryManager()->save($travels);
        $this->setReference('category_entspannung', $travels);


        $travels = $this->getCategoryManager()->create();
        $travels->setName('Körperhaltung');
        $travels->setSlug('koerperhaltung');
        $travels->setDescription('koerperhaltung');
        $travels->setEnabled(true);
        $this->getCategoryManager()->save($travels);
        $this->setReference('category_koerperhaltung', $travels);


        $travels = $this->getCategoryManager()->create();
        $travels->setName('Schmerzen');
        $travels->setSlug('schmerzen');
        $travels->setDescription('schmerzen');
        $travels->setEnabled(true);
        $this->getCategoryManager()->save($travels);
        $this->setReference('category_schmerzen', $travels);


        $travels = $this->getCategoryManager()->create();
        $travels->setName('Neuronale Verbindungen');
        $travels->setSlug('neuronale_verbindungen');
        $travels->setDescription('neuronale_verbindungen');
        $travels->setEnabled(true);
        $this->getCategoryManager()->save($travels);
        $this->setReference('category_neuronale_verbindungen', $travels);

        $travels = $this->getCategoryManager()->create();
        $travels->setName('Metabolic');
        $travels->setSlug('metabolic');
        $travels->setDescription('metabolic');
        $travels->setEnabled(true);
        $this->getCategoryManager()->save($travels);
        $this->setReference('category_metabolic', $travels);

    }
}