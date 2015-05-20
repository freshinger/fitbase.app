<?php

namespace Fitbase\Bundle\PageBundle\Listener;

use Sonata\PageBundle\Exception\InternalErrorException;
use Sonata\PageBundle\Listener\ResponseListener as ResponseListenerBase;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class ResponseListener extends ResponseListenerBase
{
    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
//    public static function getSubscribedEvents()
//    {
//        return array(
//            'kernel.response' => array('onCoreResponse')
//        );
//    }

    /**
     * Create new exercise for today
     * needs to skip today notification about
     * @param UserEvent $event
     */
    public function onCoreResponse(FilterResponseEvent $event)
    {
        $cms = $this->cmsSelector->retrieve();

        $response = $event->getResponse();
        $request = $event->getRequest();

        if ($this->cmsSelector->isEditor()) {
            $response->setPrivate();

            if (!$request->cookies->has('sonata_page_is_editor')) {
                $response->headers->setCookie(new Cookie('sonata_page_is_editor', 1));
            }
        }

        $page = $cms->getCurrentPage();

//        // display a validation page before redirecting, so the editor can edit the current page
//        if ($page && $response->isRedirection() && $this->cmsSelector->isEditor() && !$request->get('_sonata_page_skip')) {
//            $response = new Response($this->templating->render('SonataPageBundle:Page:redirect.html.twig', array(
//                'response'   => $response,
//                'page'       => $page,
//            )));
//
//            $response->setPrivate();
//
//            $event->setResponse($response);
//
//            return;
//        }

        if (!$this->decoratorStrategy->isDecorable($event->getRequest(), $event->getRequestType(), $response)) {
            return;
        }

        if (!$this->cmsSelector->isEditor() && $request->cookies->has('sonata_page_is_editor')) {
            $response->headers->clearCookie('sonata_page_is_editor');
        }

        if (!$page) {
            throw new InternalErrorException('No page instance available for the url, run the sonata:page:update-core-routes and sonata:page:create-snapshots commands');
        }

        // only decorate hybrid page or page with decorate = true
        if (!$page->isHybrid() || !$page->getDecorate()) {
            return;
        }

        $parameters = array(
            'content' => $response->getContent()
        );

        $response = $this->pageServiceManager->execute($page, $request, $parameters, $response);

        if (!$this->cmsSelector->isEditor() && $page->isCms()) {
            $response->setTtl($page->getTtl());
        }

        $event->setResponse($response);

    }
}