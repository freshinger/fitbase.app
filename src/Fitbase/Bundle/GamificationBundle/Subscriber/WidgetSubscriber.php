<?php

namespace Fitbase\Bundle\GamificationBundle\Subscriber;

use LogicException;
use Fitbase\Bundle\GamificationBundle\Event\WidgetEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class WidgetSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'fitbase_widget.dashboard_forest' => ['onDashboardForestEvent', -127],
            'fitbase_widget.dashboard_statistics' => [
                ['onDashboardDocumentationEvent', -126],
                ['onDashboardStatisticsEvent', -127]
            ],
        ];
    }

    /**
     *  Render barmer-specified forest widget
     *
     * @param WidgetEvent $event
     */
    public function onDashboardForestEvent(WidgetEvent $event)
    {
        $event->stopPropagation();
        if (!($user = $this->container->get('user')->current())) {
            throw new LogicException('User object can not be empty');
        }

        $points = 0;
        if (($company = $user->getCompany())) {
            if (($users = $company->getUsers())) {
                foreach ($users as $user) {
                    if (($pointsUser = $this->container->get('statistic')->points($user))) {
                        $points += $pointsUser;
                    }
                }
            }
        }

        $templating = $this->container->get('templating');

        $event->setResponse(
            $templating->renderResponse('Gamification/User/Dashboard/Forest.html.twig', [
                'points' => $points,
            ])
        );
    }

    /**
     * Display documentation for user
     *
     * @param WidgetEvent $event
     */
    public function onDashboardDocumentationEvent(WidgetEvent $event)
    {
        $event->stopPropagation();
        $templating = $this->container->get('templating');
        if (!($user = $this->container->get('user')->current())) {
            throw new LogicException('User object can not be empty');
        }

        $event->setResponse(
            $templating->renderResponse('Gamification/User/Dashboard/Documentation.html.twig', [

            ])
        );
    }

    /**
     * Display user statistic block
     *
     * @param WidgetEvent $event
     */
    public function onDashboardStatisticsEvent(WidgetEvent $event)
    {
        $event->stopPropagation();
        $templating = $this->container->get('templating');
        if (!($user = $this->container->get('user')->current())) {
            throw new LogicException('User object can not be empty');
        }

        $event->setResponse(
            $templating->renderResponse('Gamification/User/Dashboard/Statistics.html.twig', [

            ])
        );
    }
}