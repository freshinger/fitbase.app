<?php

namespace Fitbase\Bundle\CompanyBundle\DataFixture\ORM;
;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Fitbase\Bundle\CompanyBundle\Entity\Company;

/**
 * Generated by Webonaute\DoctrineFixtureGenerator.
 *
 */
class LoadCompany extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Set loading order.
     *
     * @return int
     */
    public function getOrder()
    {
        return 2;
    }


    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $manager->getClassMetaData(get_class(new Company()))->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);

        $item1 = new Company();
        $item1->setId(1);
        $item1->setName("Dr. Oetker");
        $item1->setDescription("CI");
        $item1->setUrl("http://www.fitbase.de");
        $item1->setSite($this->getReference('default'));
        $item1->setDate(new \DateTime("2014-06-13 15:11:42"));
        $item1->setLogo("http://online-rueckenschule.de/wp-content/uploads/logo.jpg");
        $item1->setLogoWidth(300);
        $item1->setLogoHeight(60);
        $item1->setColorHeader("63FFAC");
        $item1->setColorFooter("F7FFD1");
        $item1->setColorBackground("FF2B48");
        $item1->setQuestionnaire(1);
        $manager->persist($item1);

        $item2 = new Company();
        $item2->setId(2);
        $item2->setName("Warsteiner Brauerei");
        $item2->setUrl("Warstein");
        $item2->setSite($this->getReference('default'));
        $item2->setDate(new \DateTime("2014-06-13 15:11:42"));
        $manager->persist($item2);

        $item3 = new Company();
        $item3->setId(3);
        $item3->setName("Fitbase");
        $item3->setUrl("Hamburg");
        $item3->setSite($this->getReference('default'));
        $item3->setDate(new \DateTime("2014-06-14 09:53:59"));
        $manager->persist($item3);

        $item4 = new Company();
        $item4->setId(4);
        $item4->setName("Metallbau Fischer");
        $item4->setDescription("");
        $item4->setUrl("Lübeck");
        $item4->setSite($this->getReference('default'));
        $item4->setDate(new \DateTime("2014-06-15 18:15:34"));
        $manager->persist($item4);

        $item5 = new Company();
        $item5->setId(5);
        $item5->setName("BMW");
        $item5->setDescription("BMW");
        $item5->setUrl("http://bmw.de");
        $item5->setSite($this->getReference('default'));
        $item5->setDate(new \DateTime("2014-06-17 15:11:13"));
        $item5->setLogo("http://www.iconsdb.com/icons/preview/black/bmw-xxl.png");
        $item5->setColorHeader("FFFFFF");
        $item5->setColorFooter("030A6B");
        $item5->setColorBackground("FFFFFF");
        $item5->setQuestionnaire(1);
        $manager->persist($item5);

        $item6 = new Company();
        $item6->setId(6);
        $item6->setName("SBK-Testaktion");
        $item6->setDescription("");
        $item6->setUrl("München");
        $item6->setSite($this->getReference('default'));
        $item6->setDate(new \DateTime("2014-06-17 17:43:29"));
        $manager->persist($item6);

        $item7 = new Company();
        $item7->setId(7);
        $item7->setName("CarosUnternehmen");
        $item7->setDescription("");
        $item7->setUrl("München");
        $item7->setSite($this->getReference('default'));
        $item7->setDate(new \DateTime("2014-06-18 16:16:36"));
        $manager->persist($item7);

        $item8 = new Company();
        $item8->setId(8);
        $item8->setName("CarosUnternehmen");
        $item8->setDescription("");
        $item8->setUrl("Erlangen");
        $item8->setSite($this->getReference('default'));
        $item8->setDate(new \DateTime("2014-06-20 15:12:43"));
        $manager->persist($item8);

        $item9 = new Company();
        $item9->setId(9);
        $item9->setName("Volksbank");
        $item9->setSite($this->getReference('default'));
        $item9->setDescription("Luebeck");
        $item9->setLogo("http://online-rueckenschule.de/wp-content/uploads/online-rueckenschule-logo-300x571.png");
        $item9->setLogoWidth(300);
        $item9->setLogoHeight(57);
        $item9->setColorHeader("FFFFFF");
        $item9->setColorFooter("030A6B");
        $item9->setColorBackground("FFFFFF");
        $manager->persist($item9);


        $manager->flush();
    }

}
