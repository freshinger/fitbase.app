<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 10/11/14
 * Time: 13:58
 */

namespace Fitbase\Bundle\FitbaseBundle\Subscriber\Timeline;


use Fitbase\Bundle\FitbaseBundle\Library\Timeline\TimelineSubscriberAbstract;
use Fitbase\Bundle\UserBundle\Event\UserEvent;

class UserSubscriber extends TimelineSubscriberAbstract
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'fitbase.user.signin' => array('onUserSignIn'),
            'fitbase.user.signout' => array('onUserSignOut'),
        );
    }

    /**
     * @param UserEvent $event
     */
    public function onUserSignIn(UserEvent $event)
    {
        if (!($user = $event->getEntity())) {
            throw new \LogicException('User object can not be empty');
        }

        $this->create($this->getSubject(), 'fitbase.signin', array(
            'target' => $this->getTarget($user),
            'target_text' => $user->__toString(),
        ));
    }

    /**
     *
     * @param UserEvent $event
     */
    public function onUserSignOut(UserEvent $event)
    {
        if (!($user = $event->getEntity())) {
            throw new \LogicException('User object can not be empty');
        }

        $this->create($this->getSubject(), 'fitbase.signout', array(
            'target' => $this->getTarget($user),
            'target_text' => $user->__toString(),
        ));
    }
}