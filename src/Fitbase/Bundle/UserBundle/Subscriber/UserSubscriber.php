<?php

namespace Fitbase\Bundle\UserBundle\Subscriber;


use Cocur\Slugify\Slugify;
use Doctrine\Common\Persistence\ObjectManager;
use Fitbase\Bundle\ReminderBundle\Entity\ReminderUser;
use Fitbase\Bundle\ReminderBundle\Event\ReminderUserEvent;
use Fitbase\Bundle\UserBundle\Entity\UserFocus;
use Fitbase\Bundle\UserBundle\Entity\UserFocusCategory;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserSubscriber extends ContainerAware implements EventSubscriberInterface
{

    protected $datetime;
    protected $entityManager;
    protected $eventDispatcher;

    public function __construct(ObjectManager $entityManager, EventDispatcherInterface $eventDispatcher, $datetime)
    {
        $this->datetime = $datetime;
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'user_register' => array('onUserRegisterEvent'),
            'user_registered' => array('onUserRegisteredEvent'),
        );
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
     * Registration user event
     * @param UserEvent $event
     */
    public function onUserRegisterEvent(UserEvent $event)
    {
        if (!($user = $event->getEntity())) {
            throw new \LogicException("User object can not be empty");
        }

        if (($actioncode = $user->getActioncode())) {
            $user->setCompany($actioncode->getCompany());
            $user->setActioncode($actioncode);
        }

        $user->setEnabled(true);
        $user->setExpired(false);
        $user->setUsername($this->getUserName(
            $user->getFirstName(), $user->getLastName()
        ));

        $createEvent = new UserEvent($user);
        $this->eventDispatcher->dispatch('user_create', $createEvent);

        $this->entityManager->persist($user);
        $this->entityManager->flush($user);

        if (($actioncode = $user->getActioncode())) {

            $actioncode->setUser($user);
            $actioncode->setProcessed(true);
            $actioncode->setProcessedDate($this->datetime->getDateTime('now'));

            $this->entityManager->persist($actioncode);
            $this->entityManager->flush($actioncode);
        }

        $registeredEvent = new UserEvent($user);
        $this->eventDispatcher->dispatch('user_registered', $registeredEvent);
    }

    /**
     * Create user focus category recursive
     * @param $userFocus
     * @param $category
     */
    protected function createUserFocusCategory($userFocus, $category)
    {
        $focusCategory = new UserFocusCategory();
        $focusCategory->setFocus($userFocus);
        $focusCategory->setCategory($category);
        $focusCategory->setUpdate(true);
        $focusCategory->setPriority(count($userFocus->getCategories()));

        $this->entityManager->persist($focusCategory);
        $this->entityManager->flush($focusCategory);

        $userFocus->addCategory($focusCategory);

        $this->entityManager->persist($userFocus);
        $this->entityManager->flush($userFocus);
        $this->entityManager->refresh($userFocus);

        if (count(($children = $category->getChildren()))) {
            foreach ($children as $child) {
                $this->createUserFocusCategory($userFocus, $child);
            }
        }
    }

    /**
     * Process created user
     * todo: add cover with tests
     * @param UserEvent $event
     */
    public function onUserRegisteredEvent(UserEvent $event)
    {
        if (!($user = $event->getEntity())) {
            throw new \LogicException("User object can not be empty");
        }

        $userFocus = new UserFocus();
        $userFocus->setUser($user);
        $userFocus->setUpdate(true);
        $this->entityManager->persist($userFocus);
        $this->entityManager->flush($userFocus);

        if (($actioncode = $user->getActioncode())) {
            if (($categories = $actioncode->getCategories())) {
                foreach ($categories as $category) {
                    $this->createUserFocusCategory($userFocus, $category);
                }
            }
        } else {
            if (($company = $user->getCompany())) {
                if (($companyCategories = $company->getCategories())) {
                    foreach ($companyCategories as $companyCategory) {
                        if (($category = $companyCategory->getCategory())) {
                            $this->createUserFocusCategory($userFocus, $category);
                        }
                    }
                }
            }
        }

        $user->setFocus($userFocus);

        $repositoryGroup = $this->entityManager->getRepository('Application\Sonata\UserBundle\Entity\Group');
        if (($group = $repositoryGroup->findOneByName('User'))) {
            $user->addGroup($group);
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush($user);
    }
}