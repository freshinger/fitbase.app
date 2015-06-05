<?php

namespace Fitbase\Bundle\UserBundle\Subscriber;


use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseReminderEvent;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserEvent;
use Fitbase\Bundle\UserBundle\Entity\UserFocus;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Fitbase\Bundle\UserBundle\Event\UserFocusEvent;
use Fitbase\Bundle\UserBundle\Event\UserSingleSignOnEvent;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskReminderEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\AuthenticationEvents;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class UserFocusSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'fitbase.user_focus_update' => array('onUserFocusUpdateEvent', 128),
        );
    }

    /**
     * Update user focus and categories
     * @param UserFocusEvent $event
     */
    public function onUserFocusUpdateEvent(UserFocusEvent $event)
    {
        if (($entity = $event->getEntity())) {

            if (($categories = $entity->getCategories()) and count($categories)) {
                $this->doMarkFocusCategoriesForUpdate($entity, $categories);
            }

            $entity->setUpdate(false);
            $this->container->get('entity_manager')->persist($entity);
            $this->container->get('entity_manager')->flush($entity);
        }
    }

    /**
     *
     * @param $focus
     * @param $categories
     */
    protected function doMarkFocusCategoriesForUpdate($focus, $categories = array())
    {
        foreach ($categories as $category) {
            $category->setUpdate(true);
            $this->container->get('entity_manager')->persist($category);
            $this->container->get('entity_manager')->flush($category);
        }
    }
}