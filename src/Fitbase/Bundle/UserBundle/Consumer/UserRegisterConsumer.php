<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 12/02/15
 * Time: 14:39
 */
namespace Fitbase\Bundle\UserBundle\Consumer;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Sonata\NotificationBundle\Consumer\ConsumerEvent;
use Sonata\NotificationBundle\Consumer\ConsumerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;


class UserRegisterConsumer implements ConsumerInterface
{
    protected $entityManager;
    protected $eventDispatcher;

    public function __construct(EntityManagerInterface $entityManager, EventDispatcherInterface $eventDispatcher)
    {
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Generate unique user name
     *
     * @param $firstName
     * @param $lastName
     * @return string
     */
    protected function getUserName($firstName, $lastName)
    {
        $repositoryUser = $this->entityManager->getRepository('Application\Sonata\UserBundle\Entity\User');

        $slugify = new Slugify();
        $username = $slugify->slugify("{$firstName}_{$lastName}");
        while (($collection = $repositoryUser->findByUsername($username))) {
            $username = $username . count($collection);
        }

        return $username;
    }


    /**
     * Process message and disable user
     * @param ConsumerEvent $event
     */
    public function process(ConsumerEvent $event)
    {
//        $user->setCompany($actioncode->getCompany());
//        $user->setActioncode($actioncode);
//        $user->setExpired(false);
//        $user->setEnabled(true);
//        $user->setUsername($username);


//        $createEvent = new UserEvent($user);
//        $this->eventDispatcher->dispatch('user_create', $createEvent);


//        $entityManager->persist($user);
//        $entityManager->flush($user);
//
//        $actioncode->setUser($user);
//        $actioncode->setProcessed(true);
//        $actioncode->setProcessedDate($this->get('datetime')->getDateTime('now'));
//
//        $entityManager->persist($actioncode);
//        $entityManager->flush($actioncode);

//        $registeredEvent = new UserEvent($user);
//        $this->eventDispatcher->dispatch('user_registered', $registeredEvent);


    }
}