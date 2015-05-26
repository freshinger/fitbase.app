<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 18/05/15
 * Time: 15:48
 */

namespace Fitbase\Bundle\FitbaseBundle\Service;


use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class ServiceAuthentication extends ContainerAware implements AuthenticationFailureHandlerInterface, AuthenticationSuccessHandlerInterface
{
    /**
     * This is called when an interactive authentication attempt succeeds. This
     * is called by authentication listeners inheriting from
     * AbstractAuthenticationListener.
     *
     * @param Request $request
     * @param TokenInterface $token
     *
     * @return Response never null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        exit($this->getDashboardUrl($token));

        return new RedirectResponse($this->getDashboardUrl($token));
    }

    /**
     * On authentication failure handler
     * @param Request $request
     * @param AuthenticationException $exception
     * @return RedirectResponse|Response
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $logger = $this->container->get('logger');
        if (!($token = $exception->getToken())) {
            throw new \LogicException('Authentication token can not be empty');
        }

        try {

            if (($code = $this->container->getParameter('fitbase.soap_code'))) {
                $client = $this->container->get('besimple.soap.client.fitbase');

                $username = $token->getUser();
                $password = $token->getCredentials();

                if (($link = $client->login($code, $username, $password))) {
                    $logger->crit("User found: coaches.fitbase.de", array($username));
                    return new RedirectResponse($link);
                }
            }

            $logger->crit("User not found: client code is wrong");

        } catch (\Exception $ex) {
            $logger->crit("User not found: {$ex->getMessage()}");
        }

        $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);


        return new RedirectResponse($this->getDashboardUrl());
    }

    /**
     * Get current company url
     * @return mixed
     */
    protected function getDashboardUrl(TokenInterface $token = null)
    {
        if (!empty($token) and ($user = $token->getUser())) {
            $company = $user->getCompany();
        } else {
            $company = $company = $this->container->get('company')->current();
        }


        if (!empty($company)) {

            var_dump($company->getName());


            return $this->container->get('company')->getCompanyUrl($company, 'dashboard');
        }

        return $this->container->get('router')->generate('dashboard');
    }
}