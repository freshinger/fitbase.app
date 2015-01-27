<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Subscriber;


use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskReminderEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class WeeklytaskReminderSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'weeklytask_reminder_create' => array('onWeeklytaskReminderCreateEvent'),
        );
    }
//
//    public function doWeeklytaskUserCreate($user, $datetime)
//    {
//        $codegenerator = $this->container->get('codegenerator');
//        if (!($weeklytask = $this->container->get('weeklytask')->choose($user))) {
//            return false;
//        }
//
//        // Create reminder for weeklytask
//        $weeklytaskUser = new WeeklytaskUser();
//        $weeklytaskUser->setDone(0);
//        $weeklytaskUser->setProcessed(0);
//        $weeklytaskUser->setUser($user);
//        $weeklytaskUser->setDate($datetime);
//        $weeklytaskUser->setTask($weeklytask);
//        $weeklytaskUser->setCode($codegenerator->password(10));
//        $weeklytaskUser->setCountPoint(0);
//
//        $this->container->get('entity_manager')->persist($weeklytaskUser);
//        $this->container->get('entity_manager')->flush($weeklytaskUser);
//
//        // if a quiz for weeklytask exists
//        // create reminder for weeklyquiz
//        if (!($quiz = $weeklytask->getQuiz())) {
//            return true;
//        }
//
//        $weeklyquizUser = new WeeklyquizUser();
//        $weeklyquizUser->setDone(0);
//        $weeklyquizUser->setProcessed(0);
//        $weeklyquizUser->setQuiz($quiz);
//        $weeklyquizUser->setUser($user);
//        $weeklyquizUser->setCountPoint(0);
//        $weeklyquizUser->setCode($codegenerator->password(10));
//        $weeklyquizUser->setTask($weeklytask);
//        $weeklyquizUser->setDate($datetime->modify('+1 day'));
//        $weeklyquizUser->setUserTask($weeklytaskUser);
//
//        $this->container->get('entity_manager')->persist($weeklyquizUser);
//        $this->container->get('entity_manager')->flush($weeklyquizUser);
//
//        $weeklytaskUser->setUserQuiz($weeklyquizUser);
//        $this->container->get('entity_manager')->persist($weeklytaskUser);
//        $this->container->get('entity_manager')->flush($weeklytaskUser);
//
//        return true;
//    }

    /**
     * Create weeklytask reminder
     * @param WeeklytaskReminderEvent $event
     */
    public function onWeeklytaskReminderCreateEvent(WeeklytaskReminderEvent $event)
    {
        if (($reminderUserItem = $event->getEntity())) {
            if (($user = $reminderUserItem->getUser())) {

                $hour = $reminderUserItem->getTime()->format('H');
                $minute = $reminderUserItem->getTime()->format('i');

                $datetime = $this->container->get('datetime')->getDateTime('now');
                $datetime->setTime($hour, $minute);

                // Check is weeklytask for this date
                // already exists break up a scenario
                if (!$this->container->get('weeklytask')->isExists($user, $datetime)) {
                    // Try to create a new weeklytask for this user
                    // and this date, if task has been created,
                    // break up a scenario
                    $this->container->get('weeklytask')->create($user, $datetime);
                }

                // Check is a last weeklytask was already sent
                // for current user, than create a event that
                // a last weeklytask was sent
                if ($this->container->get('weeklytask')->isLast($user, $datetime)) {
                    if (($weeklytaskUser = $this->container->get('weeklytask')->getLast($user))) {
                        $event = new WeeklytaskUserEvent($weeklytaskUser);
                        $this->container->get('event_dispatcher')->dispatch('weeklytask_user_done_last', $event);
                    }
                }

            }
        }
    }


}