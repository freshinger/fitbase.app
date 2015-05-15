<?php
namespace Fitbase\Bundle\FitbaseBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class FitbaseTestAbstract extends WebTestCase
{
    protected $container = null;
    protected $entityManager = null;
    protected $eventDispatcher = null;
    protected $securityContainer = null;

    /**
     * Get real service container
     * @param array $options
     * @param array $server
     * @return null|\Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected function container(array $options = array(), array $server = array())
    {
        if (empty($this->container)) {
            static::bootKernel($options);
            $this->container = static::$kernel->getContainer();
        }

        return $this->container;
    }


    /**
     * Get mocked security container object
     * @return null|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function getSecurityContainer()
    {
        if (empty($this->securityContainer)) {
            $this->securityContainer = $this->getMock('Symfony\Component\Security\Core\SecurityContextInterface',
                array('isGranted', 'getToken', 'setToken'));
            $this->securityContainer->expects($this->any())
                ->method('isGranted')
                ->will($this->returnValue(true));
        }

        return $this->securityContainer;
    }

    /**
     * Get mocked entity manager object
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getEntityManager()
    {
        if (empty($this->entityManager)) {
            $this->objectManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager',
                array('merge', 'persist', 'flush', 'find', 'clear', 'detach', 'refresh', 'getRepository', 'getClassMetadata',
                    'getMetadataFactory', 'initializeObject', 'contains','remove'));
            $this->objectManager->expects($this->any())
                ->method('persist')
                ->will($this->returnValue('true'));
        }

        return $this->objectManager;
    }

    /**
     * Get mocked event dispatcher object
     * @return null|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function getEventDispatcher()
    {
        if (empty($this->eventDispatcher)) {
            $this->eventDispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface',
                array('dispatch', 'addListener', 'addSubscriber', 'removeListener', 'removeSubscriber', 'getListeners', 'hasListeners'));
            $this->eventDispatcher->expects($this->any())
                ->method('dispatch')
                ->will($this->returnValue(true));
        }

        return $this->eventDispatcher;
    }
} 