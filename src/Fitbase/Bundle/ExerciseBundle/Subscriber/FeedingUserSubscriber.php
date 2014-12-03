<?php

namespace Fitbase\Bundle\ExerciseBundle\Subscriber;


use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseReminderEvent;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserEvent;
use Fitbase\Bundle\ExerciseBundle\Event\FeedingUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskReminderEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class FeedingUserSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'feeding_user_create' => array('onFeedingUserCreateEvent'),
        );
    }

    /**
     *
     * @param FeedingUserEvent $event
     */
    public function onFeedingUserCreateEvent(FeedingUserEvent $event)
    {

        if (($feedingUser = $event->getEntity())) {

            $this->container->get('entity_manager')->persist($feedingUser);
            $this->container->get('entity_manager')->flush($feedingUser);

            if (($collection = $feedingUser->getItems())) {
                foreach ($collection as $feedingUserItem) {
                    $feedingUserItem->setFeeding($feedingUser);
                    $this->container->get('entity_manager')->persist($feedingUserItem);
                }
                $this->container->get('entity_manager')->flush();
            }
        }
    }
}