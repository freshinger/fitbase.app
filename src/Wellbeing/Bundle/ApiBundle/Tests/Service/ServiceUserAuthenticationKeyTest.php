<?php

namespace Wellbeing\Bundle\ApiBundle\Tests\Service;


use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\FitbaseBundle\Tests\FitbaseTestAbstract;
use Wellbeing\Bundle\ApiBundle\Entity\UserAuthenticationKey;
use Wellbeing\Bundle\ApiBundle\Service\ServiceUserAuthenticationKey;

class ServiceUserAuthenticationKeyTest extends FitbaseTestAbstract
{
    /**
     * Setup user object for current test
     *
     * @return User
     */
    protected function getUser()
    {
        return (new User());
    }


    public function testStartShouldPersistAnObject()
    {
        $entityManager = $this->getEntityManager();

        $persisted = null;
        $entityManager->expects($this->any())
            ->method('persist')
            ->will($this->returnCallback(function ($entity) use (&$persisted) {
                $persisted = $entity;
            }));

        $datetime = $this->container()->get('datetime');
        $generator = $this->container()->get('codegenerator');

        $service = new ServiceUserAuthenticationKey($entityManager, $datetime);

        $service->start($this->getUser(), $generator->code());

        $this->assertTrue(is_object($persisted));
        $this->assertTrue($persisted instanceof UserAuthenticationKey);
    }

    public function testCloseShouldReturnTrue()
    {
        $entityManager = $this->getEntityManager();

        $persisted = null;
        $entityManager->expects($this->any())
            ->method('persist')
            ->will($this->returnCallback(function ($entity) use (&$persisted) {
                $persisted = $entity;
            }));

        $datetime = $this->container()->get('datetime');
        $generator = $this->container()->get('codegenerator');

        $service = new ServiceUserAuthenticationKey($entityManager, $datetime);

        $response = $service->close($generator->code());

        $this->assertTrue($response);
    }


} 