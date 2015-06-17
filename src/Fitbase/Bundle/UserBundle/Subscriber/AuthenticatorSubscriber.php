<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/06/15
 * Time: 11:09
 */

namespace Fitbase\Bundle\UserBundle\Subscriber;


use Fitbase\Bundle\FitbaseBundle\Event\AuthenticateTokenEvent;
use Fitbase\Bundle\FitbaseBundle\Event\PreAuthenticatedTokenEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class AuthenticatorSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Returns the events to which this class has subscribed.
     *
     * Return format:
     *     array(
     *         array('event' => 'the-event-name', 'method' => 'onEventName', 'class' => 'some-class', 'format' => 'json'),
     *         array(...),
     *     )
     *
     * The class may be omitted if the class wants to subscribe to events of all classes.
     * Same goes for the format key.
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'fitbase.preauthenticated_token_create' => ['onPreauthenticatedTokenCreateEvent'],
            'fitbase.preauthenticated_token_authenticate' => ['onPreauthenticatedTokenAuthenticate']
        ];
    }

    /**
     * Prepare preauthentication token
     * @param PreAuthenticatedTokenEvent $event
     */
    public function onPreauthenticatedTokenCreateEvent(PreAuthenticatedTokenEvent $event)
    {
        if (($request = $event->getRequest()) and strlen(($sign = $request->get('sign')))) {

            $token = new PreAuthenticatedToken(
                'anon.', $sign, $event->getProvider()
            );

            $event->setToken($token)
                ->stopPropagation();

        }
    }

    /**
     * Authenticate user in system
     * @param AuthenticateTokenEvent $event
     */
    public function onPreauthenticatedTokenAuthenticate(AuthenticateTokenEvent $event)
    {
        if (($token = $event->getToken())) {

            if (!is_string((($credentials = $token->getCredentials())))) {
                return;
            }

            $entityManager = $this->container->get('entity_manager');
            $repositoryExerciseUser = $entityManager->getRepository('Fitbase\Bundle\UserBundle\Entity\UserSingleSignOn');

            if (($singlesignon = $repositoryExerciseUser->findOneByCodeAndNotProcessed($credentials))) {

                if ($this->isExpired($singlesignon)) {
                    throw new AuthenticationException("API Key {$credentials} already expired.");
                }

                if (!($user = $singlesignon->getUser())) {
                    throw new \LogicException('User object can not be empty');
                }

                $token = new PreAuthenticatedToken(
                    $user, $sign, $event->getProviderKey(), $user->getRoles()
                );

                $event->setToken($token)
                    ->stopPropagation();
            }
        }
    }

    /**
     * Check is singlesignon is expired
     * @param $singlesignon
     * @return mixed
     */
    protected function isExpired($singlesignon)
    {
        $datetime = $this->container->get('datetime');
        $singlesignon->setProcessedDate($datetime->getDateTime('now'));

        if (($date = $singlesignon->getDate())) {
            $date->modify('+1 week');
            if ($datetime->getDateTime('now') >= $date) {
                $singlesignon->setProcessed(true);
            }
        }

        $this->container->get('entity_manager')->persist($singlesignon);
        $this->container->get('entity_manager')->flush($singlesignon);

        return $singlesignon->getProcessed();
    }
}