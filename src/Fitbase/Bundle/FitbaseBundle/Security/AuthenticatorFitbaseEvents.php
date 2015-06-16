<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 18/03/15
 * Time: 14:57
 */

namespace Fitbase\Bundle\FitbaseBundle\Security;


use Fitbase\Bundle\FitbaseBundle\Event\AuthenticateTokenEvent;
use Fitbase\Bundle\FitbaseBundle\Event\PreAuthenticatedTokenEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\SimplePreAuthenticatorInterface;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class AuthenticatorFitbaseEvents extends ContainerAware implements SimplePreAuthenticatorInterface
{
    /**
     * Create pre authenticate token
     *
     * @param Request $request
     * @param $providerKey
     * @return PreAuthenticatedToken
     */
    public function createToken(Request $request, $providerKey)
    {
        $event = new PreAuthenticatedTokenEvent($request, $providerKey);

        $this->container->get('event_dispatcher')->dispatch(
            'fitbase.preauthenticated_token_create', $event);

        if (($token = $event->getToken())) {
            return $token;
        }
    }

    /**
     * @param TokenInterface $token
     * @param UserProviderInterface $userProvider
     * @param $providerKey
     * @return TokenInterface
     */
    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey)
    {
        $event = new AuthenticateTokenEvent($token, $userProvider, $providerKey);

        $this->container->get('event_dispatcher')->dispatch(
            'fitbase.preauthenticated_token_authenticate', $event);

        if (($token = $event->getToken())) {
            return $token;
        }
    }

    /**
     * Check for supportet tokens
     * @param TokenInterface $token
     * @param $providerKey
     * @return bool
     */
    public function supportsToken(TokenInterface $token, $providerKey)
    {
        return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
    }
} 