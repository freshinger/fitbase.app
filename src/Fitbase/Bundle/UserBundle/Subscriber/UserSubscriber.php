<?php

namespace Fitbase\Bundle\UserBundle\Subscriber;


use Fitbase\Bundle\ReminderBundle\Entity\ReminderUser;
use Fitbase\Bundle\ReminderBundle\Event\ReminderUserEvent;
use Fitbase\Bundle\UserBundle\Entity\UserFocus;
use Fitbase\Bundle\UserBundle\Entity\UserFocusCategory;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'user_registered' => array('onUserRegisteredEvent'),
        );
    }

    /**
     * Process created user
     * @param UserEvent $event
     */
    public function onUserRegisteredEvent(UserEvent $event)
    {
        $entityManager = $this->container->get('entity_manager');
        if (($user = $event->getEntity())) {

            $userFocus = new UserFocus();
            $userFocus->setUser($user);
            $entityManager->persist($userFocus);
            $entityManager->flush($userFocus);

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


            $entityManager = $this->container->get('entity_manager');
            $repositoryGroup = $entityManager->getRepository('Application\Sonata\UserBundle\Entity\Group');
            if (($group = $repositoryGroup->findOneByName('User'))) {
                $user->addGroup($group);
            }

            $entityManager->persist($user);
            $entityManager->flush($user);
        }
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
        $focusCategory->getUpdate(true);
        $focusCategory->setPriority(count($userFocus->getCategories()));

        $this->container->get('entity_manager')->persist($focusCategory);
        $this->container->get('entity_manager')->flush($focusCategory);

        $userFocus->addCategory($focusCategory);

        $this->container->get('entity_manager')->persist($userFocus);
        $this->container->get('entity_manager')->flush($userFocus);
        $this->container->get('entity_manager')->refresh($userFocus);

        if (count(($children = $category->getChildren()))) {
            foreach ($children as $child) {
                $this->createUserFocusCategory($userFocus, $child);
            }
        }
    }
}