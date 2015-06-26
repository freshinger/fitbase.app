<?php

namespace Fitbase\Bundle\BarmerGekBundle\Subscriber;

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
            'fitbase_widget.dashboard_forest' => ['onDashboardForestEvent', 127],
        ];
    }

    /**
     *  Render barmer-specified forest widget
     *
     * @param WidgetEvent $event
     */
    public function onDashboardForestEvent(WidgetEvent $event)
    {
        if (!($company = $this->container->get('company')->current())) {
            throw new LogicException('Company object can not be empty');
        }

        if (!in_array($company->getSlug(), ['barmer_gek', 'barmergek', 'barmer'])) {
            return;
        }

        if (!($user = $this->container->get('user')->current())) {
            throw new LogicException('User object can not be empty');
        }

        if (!$user->getPrivatePerson()) {
            return;
        }

        $event->stopPropagation();

        $templating = $this->container->get('templating');

        $event->setResponse(
            $templating->renderResponse('BarmerGek/User/Dashboard/Teledoctor.html.twig', [

            ])
        );
    }
}