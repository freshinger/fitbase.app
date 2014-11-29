<?php

/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fitbase\Bundle\FitbaseBundle\Listener;

use Sonata\PageBundle\CmsManager\CmsManagerSelectorInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sonata\PageBundle\Site\SiteSelectorInterface;
use Sonata\PageBundle\Exception\InternalErrorException;
use Sonata\PageBundle\Page\PageServiceManagerInterface;
use Sonata\PageBundle\CmsManager\DecoratorStrategyInterface;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Templating\EngineInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * ExceptionListener.
 *
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
class ExceptionListener extends ContainerAware implements AuthenticationEntryPointInterface
{
    /**
     * @param Request $request
     * @param AuthenticationException $authException
     * @return RedirectResponse|Response
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new RedirectResponse($this->container->get('router')->generate('sonata_user_security_login'));
    }
}
