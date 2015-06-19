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

class WeeklytaskUserSubscriber extends ContainerAware implements EventSubscriberInterface
{

    /**
     * Date time generator
     *
     * @var
     */
    protected $datetime;

    /**
     * Weeklytask service object
     *
     * @var
     */
    protected $weeklytask;

    /**
     * Entity Manager service
     * @var
     */
    protected $entityManager;

    /**
     * Class constructor
     *
     * @param $datetime
     * @param $weeklytask
     * @param $entityManager
     */
    public function __construct($datetime, $weeklytask, $entityManager)
    {
        $this->datetime = $datetime;
        $this->weeklytask = $weeklytask;
        $this->entityManager = $entityManager;
    }

    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'fitbase.weeklytask_reminder_last' => ['onWeeklytaskReminderLastEvent'],
        );
    }

    /**
     * Disable user
     *
     * @param WeeklytaskUserEvent $event
     */
    public function onWeeklytaskReminderLastEvent(WeeklytaskUserEvent $event)
    {
        $datetime = $this->datetime;
        $serviceWeeklytask = $this->weeklytask;
        $entityManager = $this->entityManager;

        if (!($weeklytaskUser = $event->getEntity())) {
            throw new \LogicException('Weeklytask user object can not be empty');
        }

        if (!($user = $weeklytaskUser->getUser())) {
            throw new \LogicException('User object can not be empty');
        }

        $date = $datetime->getDateTime('now');
        if (($actioncode = $user->getActioncode()) and $actioncode->getExpire()) {

            if (!($weeklytaskUser = $serviceWeeklytask->last($user))) {
                throw new \LogicException('Last weeklytask user object can not be empty');
            }

            if (($interval = $date->diff($weeklytaskUser->getDate()))) {
                if (((int)$interval->format('%a')) >= 7) {

                    $user->setExpired(true);

                    $entityManager->persist($user);
                    $entityManager->flush($user);
                }
            }
        }
    }
}