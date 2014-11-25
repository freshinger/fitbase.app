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
use Symfony\Component\Finder\Finder;

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
        $imageCollection = Finder::create()->name('default.png')->in(__DIR__ . '/../data');

        $image = null;
        if (($iterator = $imageCollection->getIterator())) {
            if (($file = $iterator->current())) {

                $manager = $this->getMediaManager();
                $image = $manager->create();
                $image->setBinaryContent($file);
                $image->setEnabled(true);
                $image->setName($file->getFilename());
                $image->setDescription($file->getFilename());
                $image->setAuthorName('Fitbase');
                $image->setCopyright('Fitbase');

                $manager->save($image, 'exercise', 'sonata.media.provider.image');
            }
        }

        // Travels category
        $travels = $this->getCategoryManager()->create();
        $travels->setName('Rücken');
        $travels->setSlug('ruecken');
        $travels->setDescription('Schulter und Nachen, mitlere und untere Rücken');
        $travels->setEnabled(true);
        $travels->setMedia($image);
        $this->getCategoryManager()->save($travels);
        $this->setReference('category_ruecken', $travels);


        // Travels category
        $travels = $this->getCategoryManager()->create();
        $travels->setName('Augen');
        $travels->setSlug('Augen');
        $travels->setDescription('Augen Entspannung');
        $travels->setEnabled(true);
        $travels->setMedia($image);
        $this->getCategoryManager()->save($travels);
        $this->setReference('category_augen', $travels);

        // Travels category
        $travels = $this->getCategoryManager()->create();
        $travels->setName('RSI');
        $travels->setSlug('rsi');
        $travels->setDescription('RSI');
        $travels->setEnabled(true);
        $travels->setMedia($image);
        $this->getCategoryManager()->save($travels);
        $this->setReference('category_rsi', $travels);

        $stress = $this->getCategoryManager()->create();
        $stress->setName('Stress');
        $stress->setSlug('stress');
        $stress->setDescription('stress');
        $stress->setEnabled(true);
        $stress->setMedia($image);
        $this->getCategoryManager()->save($stress);
        $this->setReference('category_stress', $stress);

        $travels = $this->getCategoryManager()->create();
        $travels->setName('Übersäuerung');
        $travels->setSlug('uebersaeuerung');
        $travels->setDescription('uebersäuerung');
        $travels->setEnabled(true);
        $travels->setMedia($image);
        $travels->setParent($this->getReference('category_ruecken'));
        $this->getCategoryManager()->save($travels);
        $this->setReference('category_uebersäuerung', $travels);

        $travels = $this->getCategoryManager()->create();
        $travels->setName('Verspannungen');
        $travels->setSlug('verspannungen');
        $travels->setDescription('verspannungen');
        $travels->setEnabled(true);
        $travels->setMedia($image);
        $travels->setParent($this->getReference('category_ruecken'));
        $this->getCategoryManager()->save($travels);
        $this->setReference('category_verspannungen', $travels);

        $travels = $this->getCategoryManager()->create();
        $travels->setName('Bandscheiben');
        $travels->setSlug('bandscheiben');
        $travels->setDescription('bandscheiben');
        $travels->setEnabled(true);
        $travels->setMedia($image);
        $travels->setParent($this->getReference('category_ruecken'));
        $this->getCategoryManager()->save($travels);
        $this->setReference('category_bandscheiben', $travels);

        $travels = $this->getCategoryManager()->create();
        $travels->setName('Atmung');
        $travels->setSlug('atmung');
        $travels->setDescription('atmung');
        $travels->setEnabled(true);
        $travels->setMedia($image);
        $this->getCategoryManager()->save($travels);
        $this->setReference('category_atmung', $travels);

        $travels = $this->getCategoryManager()->create();
        $travels->setName('Arbeitsplatzergonomie');
        $travels->setSlug('arbeitsplatzergonomie');
        $travels->setDescription('arbeitsplatzergonomie');
        $travels->setEnabled(true);
        $travels->setParent($this->getReference('category_ruecken'));
        $this->getCategoryManager()->save($travels);
        $this->setReference('category_arbeitsplatzergonomie', $travels);

        $travels = $this->getCategoryManager()->create();
        $travels->setName('Gewohnheiten');
        $travels->setSlug('gewohnheiten');
        $travels->setDescription('gewohnheiten');
        $travels->setEnabled(true);
        $travels->setMedia($image);
        $travels->setParent($this->getReference('category_ruecken'));
        $this->getCategoryManager()->save($travels);
        $this->setReference('category_gewohnheiten', $travels);

        $travels = $this->getCategoryManager()->create();
        $travels->setName('Entspannung');
        $travels->setSlug('entspannung');
        $travels->setDescription('entspannung');
        $travels->setEnabled(true);
        $travels->setMedia($image);
        $travels->setParent($this->getReference('category_ruecken'));
        $this->getCategoryManager()->save($travels);
        $this->setReference('category_entspannung', $travels);


        $travels = $this->getCategoryManager()->create();
        $travels->setName('Körperhaltung');
        $travels->setSlug('koerperhaltung');
        $travels->setDescription('koerperhaltung');
        $travels->setEnabled(true);
        $travels->setMedia($image);
        $travels->setParent($this->getReference('category_ruecken'));
        $this->getCategoryManager()->save($travels);
        $this->setReference('category_koerperhaltung', $travels);


        $travels = $this->getCategoryManager()->create();
        $travels->setName('Schmerzen');
        $travels->setSlug('schmerzen');
        $travels->setDescription('schmerzen');
        $travels->setEnabled(true);
        $travels->setMedia($image);
        $travels->setParent($this->getReference('category_ruecken'));
        $this->getCategoryManager()->save($travels);
        $this->setReference('category_schmerzen', $travels);


        $travels = $this->getCategoryManager()->create();
        $travels->setName('Neuronale Verbindungen');
        $travels->setSlug('neuronale_verbindungen');
        $travels->setDescription('neuronale_verbindungen');
        $travels->setEnabled(true);
        $travels->setMedia($image);
        $travels->setParent($this->getReference('category_ruecken'));
        $this->getCategoryManager()->save($travels);
        $this->setReference('category_neuronale_verbindungen', $travels);

        $travels = $this->getCategoryManager()->create();
        $travels->setName('Metabolic');
        $travels->setSlug('metabolic');
        $travels->setDescription('metabolic');
        $travels->setEnabled(true);
        $travels->setMedia($image);
        $this->getCategoryManager()->save($travels);
        $this->setReference('category_metabolic', $travels);

        $travels = $this->getCategoryManager()->create();
        $travels->setName('Ernährung');
        $travels->setSlug('ernaehrung');
        $travels->setDescription('ernaehrung');
        $travels->setEnabled(true);
        $travels->setMedia($image);
        $travels->setParent($this->getReference('category_metabolic'));
        $this->getCategoryManager()->save($travels);
        $this->setReference('category_ernaehrung', $travels);

    }
}