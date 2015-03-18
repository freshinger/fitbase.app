<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 18/03/15
 * Time: 14:57
 */

namespace Fitbase\Bundle\UserBundle\Security;


use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\SimplePreAuthenticatorInterface;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class AuthenticatorSinglesignon extends ContainerAware implements SimplePreAuthenticatorInterface
{
    /**
     * Create preauthenticate token
     *
     * @param Request $request
     * @param $providerKey
     * @return PreAuthenticatedToken
     */
    public function createToken(Request $request, $providerKey)
    {
        if (strlen(($sign = $request->get('sign')))) {
            return new PreAuthenticatedToken(
                'anon.',
                $sign,
                $providerKey
            );
        }
    }

    /**
     * Authenticate user
     * @param TokenInterface $token
     * @param UserProviderInterface $userProvider
     * @param $providerKey
     */
    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey)
    {
        if (($sign = $token->getCredentials())) {
            $entityManager = $this->container->get('entity_manager');
            $repositoryExerciseUser = $entityManager->getRepository('Fitbase\Bundle\UserBundle\Entity\UserSingleSignOn');
            if (($singlesignon = $repositoryExerciseUser->findOneByCodeAndNotProcessed($sign))) {

                if (!$this->isExpired($singlesignon)) {
                    if (($user = $singlesignon->getUser())) {
                        return new PreAuthenticatedToken(
                            $user,
                            $sign,
                            $providerKey,
                            $user->getRoles()
                        );
                    }
                }
            }

            throw new AuthenticationException(
                sprintf('API Key "%s" does not exist.', $sign)
            );
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