<?php

namespace Fitbase\Bundle\CompanyBundle\Subscriber;

use Sonata\PageBundle\Model\SiteInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Sonata\PageBundle\Exception\PageNotFoundException;

class KernelSubscriber extends ContainerAware implements EventSubscriberInterface
{
    protected $request;
    protected $companyService;
    protected $siteService;

    public function __construct($companyService, $siteService, $request)
    {
        $this->request = $request;
        $this->companyService = $companyService;
        $this->siteService = $siteService;
    }

    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => array('onKernelRequestEvent', 29),
            KernelEvents::RESPONSE => array('onKernelResponseEvent', 128),
        );
    }

    /**
     * Check is user have a rights to access current site
     * throw an exception if not
     *
     * @param GetResponseEvent $event
     */
    public function onKernelRequestEvent(GetResponseEvent $event)
    {
        if (($company = $this->companyService->current()) and ($site = $company->getSite())) {

            if ($this->match($site)) {
                return;
            }

            $uri = htmlspecialchars($this->request->getUri(), ENT_QUOTES);
            throw new PageNotFoundException("Requested site not available for current user: {$uri}");
        }
    }

    /**
     * Check sites match
     * @param SiteInterface $site
     * @return bool
     */
    protected function match(SiteInterface $site = null)
    {
        if (!is_null($site) and ($current = $this->siteService->retrieve())) {
            return $current->getId() == $site->getId();
        }
        return true;
    }

    /**
     * store given company to session
     *
     * @param FilterResponseEvent $event
     */
    public function onKernelResponseEvent(FilterResponseEvent $event)
    {
        if (($slug = $event->getRequest()->get('company'))) {
            $event->getRequest()->getSession()->set('company', $slug);
        }
    }
}