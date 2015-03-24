<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 10/11/14
 * Time: 13:58
 */

namespace Fitbase\Bundle\UserBundle\Subscriber;

use Fitbase\Bundle\FitbaseBundle\Event\UserWizardEvent;
use Fitbase\Bundle\UserBundle\Controller\UserWizardController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;

class UserWizardDoneSubscriber implements EventSubscriberInterface
{
    protected $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'user_wizard' => array('onUserWizardEvent', -128),
        );
    }

    /**
     * Set wizart as done
     * @param UserWizardEvent $event
     */
    public function onUserWizardEvent(UserWizardEvent $event)
    {
        if (($user = $event->getEntity())) {
            if (!$user->getWizard()) {
                $user->setWizard(1);
                $this->entityManager->persist($user);
                $this->entityManager->flush($user);
            }
        }
    }
}