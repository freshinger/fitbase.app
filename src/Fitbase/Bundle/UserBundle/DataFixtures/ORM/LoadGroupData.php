<?php

namespace Fitbase\Bundle\UserBundle\DataFixture\ORM;
;

use Application\Sonata\UserBundle\Entity\Group;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Fitbase\Bundle\ExerciseBundle\Entity\Exercise;

/**
 * Generated by Webonaute\DoctrineFixtureGenerator.
 *
 */
class LoadGroupData extends AbstractFixture implements OrderedFixtureInterface
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
        $entity = new Group("Administrator");
        $entity->addRole("ROLE_SUPER_ADMIN");
        $manager->persist($entity);
        $manager->flush($entity);

        $entity = new Group("User");
        $entity->addRole("ROLE_USER");
        $manager->persist($entity);
        $manager->flush($entity);

        $entity = new Group("Company");
        $entity->addRole("ROLE_COMPANY");
        $manager->persist($entity);
        $manager->flush($entity);
    }

}
