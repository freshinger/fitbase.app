<?php

namespace Fitbase\Bundle\UserBundle\Subscriber;


use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseReminderEvent;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserEvent;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
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

class UserActioncodeSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'kernel.request' => array('onKernelRequestEvent', -128),
        );
    }

    /**
     * Check for sign in request and autosignon when found
     * @param GetResponseEvent $event
     */
    public function onKernelRequestEvent(GetResponseEvent $event)
    {
        if (($request = $event->getRequest())) {

//            if (($singlesignon = $request->get('sign'))) {
//
//                $entityManager = $this->container->get('entity_manager');
//                $repositoryExerciseUser = $entityManager->getRepository('Fitbase\Bundle\UserBundle\Entity\UserSingleSignOn');
//                if (($userSingleSignOn = $repositoryExerciseUser->findOneByCodeAndNotProcessed($singlesignon))) {
//                    if (($user = $userSingleSignOn->getUser())) {
//
//                        $datetime = $this->container->get('datetime');
//                        $userSingleSignOn->setProcessedDate($datetime->getDateTime('now'));
//
//                        if (($date = $userSingleSignOn->getDate())) {
//                            $date->modify('+1 week');
//                        }
//
//                        if ($datetime->getDateTime('now') >= $date) {
//                            $userSingleSignOn->setProcessed(1);
//                        }
//
//                        $this->container->get('entity_manager')->persist($userSingleSignOn);
//                        $this->container->get('entity_manager')->flush($userSingleSignOn);
//
//                        //TODO: do not process disabled and inactive users
//                        if (!$userSingleSignOn->getProcessed()) {
//                            $token = new UsernamePasswordToken($user, null, 'admin', $user->getRoles());
//                            $this->container->get('security.context')->setToken($token);
//                        }
//
//                    }
//                }
//            }
        }
    }
}