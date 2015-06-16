<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/06/15
 * Time: 11:09
 */

namespace Fitbase\Bundle\BarmerGekBundle\Subscriber;


use Fitbase\Bundle\BarmerGekBundle\Model\SessionKey;
use Fitbase\Bundle\FitbaseBundle\Event\AuthenticateTokenEvent;
use Fitbase\Bundle\FitbaseBundle\Event\PreAuthenticatedTokenEvent;
use Fitbase\Bundle\BarmerGekBundle\Exception\FitbaseUserRegistrationException;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;

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
        if (($request = $event->getRequest())) {

            if (($userId = $request->get('userId')) and
                ($sessionKey = $request->get('sessionKey'))) {

                $token = new PreAuthenticatedToken(
                    'anon.', (new SessionKey())
                        ->setUserId($userId)
                        ->setSessionKey($sessionKey)
                    , $event->getProvider()
                );

                $event->setToken($token)
                    ->stopPropagation();
            }
        }
    }

    /**
     * Authenticate user in system
     * @param AuthenticateTokenEvent $event
     */
    public function onPreauthenticatedTokenAuthenticate(AuthenticateTokenEvent $event)
    {
        if (($token = $event->getToken()) and ($credentials = $token->getCredentials())) {

            if (!$credentials instanceof SessionKey) {
                return;
            }

            //TODO: check use authentication using barmer api
            //TODO: try to find an existed user in out database

//                $token = new PreAuthenticatedToken(
//                    $user, $sign, $event->getProviderKey(), $user->getRoles()
//                );
//
//                $event->setToken($token)
//                    ->stopPropagation();

            throw new FitbaseUserRegistrationException('User has to be registered on fitbase.de');
        }
    }

}