<?php

namespace Fitbase\Bundle\ReminderBundle\Listener;

use Symfony\Component\DependencyInjection\ContainerAware;
use Fitbase\Bundle\ReminderBundle\Event\ReminderUserPlanEvent;

class EmailListener extends ContainerAware
{
    /**
     * Send user notification
     * @param ReminderUserPlanEvent $event
     * @return bool
     */
    public function onReminderUserSender(ReminderUserPlanEvent $event)
    {
        assert(($plan = $event->getEntity()));

        $logger = $this->container->get('logger');

        $user = $this->container->get('user')->find($plan->getUserId());

        if ($user == null) {
            $logger->info('Reminder, user not exists');

            $event = new ReminderUserPlanEvent($plan);
            $this->container->get('event_dispatcher')->dispatch('reminder_sent', $event);

            return false;
        }

        $dateTime = $this->container->get('datetime');

        $statisticRepository = $this->container->get('entity_manager')
            ->getRepository('Fitbase\Bundle\StatisticBundle\Entity\UserStatisticExercise');

        $content = $this->container->get('templating')->render('FitbaseReminderBundle:Email:reminder.html.twig', array(
            'user' => $user,
            'reminder_code' => md5(date('Yn') * $user->getId()),
            'first_name' => $user->getMetaValue('first_name'),
            'last_name' => $user->getMetaValue('last_name'),
            'last_view' => $statisticRepository->getUserViewDateLast($user->getId()),
            'views_week' => $statisticRepository->getUserViewCountLastWeek($user->getId(), $dateTime),
            'views_total' => $statisticRepository->getUserViewCountTotal($user->getId()),
        ));

        $this->container->get('fitbase_mailer')
            ->mail($user->getEmail(), 'Ihr Online-Rückenschule.de Erinnerungsservice', $content);

        $event = new ReminderUserPlanEvent($plan);
        $this->container->get('event_dispatcher')->dispatch('reminder_sent', $event);

        $logger->info('Reminder, sender done', array($user->getId(), $plan->getId(),));
    }
}
