<?php

namespace Fitbase\Bundle\UserBundle\Subscriber;


use Application\Sonata\UserBundle\Entity\User;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Persistence\ObjectManager;
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
            'fitbase.user_register' => array('onUserRegisterEvent'),
            'fitbase.user_registered' => array('onUserRegisteredEvent'),
            'fitbase.user_remove' => array('onUserRemoveEvent'),
            'fitbase.user_remove_prepare' => array('onUserRemovePrepareEvent'),
            'fitbase.user_remove_recover' => array('onUserRemoveRecoverEvent'),
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
        $this->eventDispatcher->dispatch('fitbase.user_create', $createEvent);

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
        $this->eventDispatcher->dispatch('fitbase.user_registered', $registeredEvent);
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
            $this->doAppendFocusCategoriesFromActioncode($userFocus, $actioncode);
        } else if (($company = $user->getCompany())) {
            $this->doAppendFocusCategoriesFromCompany($userFocus, $company);
        }

        if (($userFocusCategory = $userFocus->getFirstCategory())) {
            $this->doAppendFocusSettingsDefault($userFocus, $userFocusCategory);
        }

        $user->setFocus($userFocus);


        $this->doAppendUserGroupDefault($user);
        $this->entityManager->persist($user);
        $this->entityManager->flush($user);
    }

    /**
     * Append default user group
     * @param User $user
     */
    protected function doAppendUserGroupDefault(User $user)
    {
        $repositoryGroup = $this->entityManager->getRepository('Application\Sonata\UserBundle\Entity\Group');
        if (($group = $repositoryGroup->findOneByName('User'))) {
            $user->addGroup($group);
        }
    }

    /**
     * Append focus sub-categories by default
     *
     * @param $userFocus
     */
    protected function doAppendFocusSettingsDefault($userFocus, $userFocusCategory)
    {
        if (($category = $userFocusCategory->getCategory())) {
            if (in_array($category->getSlug(), array('ruecken', 'rucken', 'rcken'))) {
                if (!$userFocusCategory->getPrimary()) {

                    $userFocusCategory->setType(0); // Mobilisation,  Kraeftigung, Daehnung

                    $obererRuecken = $userFocus->getCategoryBySlug('oberer-ruecken');
                    $userFocusCategory->addPrimary($obererRuecken);

                    $untererRuecken = $userFocus->getCategoryBySlug('unterer-ruecken');
                    $userFocusCategory->addPrimary($untererRuecken);

                    $mittlererRuecken = $userFocus->getCategoryBySlug('mittlerer-ruecken');
                    $userFocusCategory->addPrimary($mittlererRuecken);

                    $this->entityManager->persist($userFocusCategory);
                    $this->entityManager->flush($userFocusCategory);
                }
            }
        }
    }

    /**
     * Get categories from company
     * and add to user focus
     *
     * @param $userFocus
     * @param $company
     */
    protected function doAppendFocusCategoriesFromCompany($userFocus, $company)
    {
        if (($companyCategories = $company->getCategories())) {
            foreach ($companyCategories as $companyCategory) {
                if (($category = $companyCategory->getCategory())) {
                    $this->doCreateUserFocusCategory($userFocus, $category);
                }
            }
        }
    }

    /**
     * Get categories from actioncode
     * and add to user focus
     *
     * @param $userFocus
     * @param $actioncode
     */
    protected function doAppendFocusCategoriesFromActioncode($userFocus, $actioncode)
    {
        if (($categories = $actioncode->getCategories())) {
            foreach ($categories as $category) {
                $this->doCreateUserFocusCategory($userFocus, $category);
            }
        }
    }

    /**
     * Create user focus category recursive
     * @param $userFocus
     * @param $category
     */
    protected function doCreateUserFocusCategory($userFocus, $category)
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
                $this->doCreateUserFocusCategory($userFocus, $child);
            }
        }
    }

    /**
     * Remove user from database
     *
     * @param UserEvent $event
     */
    public function onUserRemoveEvent(UserEvent $event)
    {
        if (!($user = $event->getEntity())) {
            throw new \LogicException("User object can not be empty");
        }

        $this->entityManager->remove($user);
        $this->entityManager->flush($user);
    }

    /**
     * Prepare user to remove in 2 weeks
     * @param UserEvent $event
     */
    public function onUserRemovePrepareEvent(UserEvent $event)
    {
        if (!($user = $event->getEntity())) {
            throw new \LogicException("User object can not be empty");
        }

        $user->setRemoveRequest(true);
        $user->setRemoveRequestAt($this->datetime->getDateTime('now'));

        $this->entityManager->persist($user);
        $this->entityManager->flush($user);
    }

    /**
     *  Undone remove request
     *
     * @param UserEvent $event
     */
    public function onUserRemoveRecoverEvent(UserEvent $event)
    {
        if (!($user = $event->getEntity())) {
            throw new \LogicException("User object can not be empty");
        }

        $user->setRemoveRequest(null);
        $user->setRemoveRequestAt(null);

        $this->entityManager->persist($user);
        $this->entityManager->flush($user);
    }
}