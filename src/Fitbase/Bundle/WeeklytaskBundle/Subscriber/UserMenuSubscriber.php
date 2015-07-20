<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Subscriber;


use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseReminderEvent;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskReminderEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserMenuSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'fitbase.user_menu' => ['onUserMenuEvent', -127],
        ];
    }

    /**
     * Process menu event, to fill custom menu from this bundle
     * @param \Fitbase\Bundle\FitbaseBundle\Event\UserMenuEvent $event
     */
    public function onUserMenuEvent(\Fitbase\Bundle\FitbaseBundle\Event\UserMenuEvent $event)
    {
        $translator = $this->container->get('translator');
        if (!($menu = $event->getEntity())) {
            throw new \LogicException('Menu object can not be empty');
        }

        $menu->addChild($translator->trans('weeklytask.weeklytask_title', [], 'FitbaseWeeklytaskBundle'), [
            'route' => 'weeklytask_dashboard',
        ]);
    }

}