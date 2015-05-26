<?php

namespace Fitbase\Bundle\CompanyBundle\Subscriber;

use Sonata\PageBundle\Model\SiteInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Sonata\PageBundle\Exception\PageNotFoundException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RequestSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => array('onKernelRequest', 29),
        );
    }

    /**
     *
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {

        var_dump(get_class($this->container->get('router')));

        if (($company = $this->container->get('company')->current())) {
            if (($site = $company->getSite())) {
//                if (!$this->siteMatch($company->getSite())) {

                var_dump($site->getHost());

                $context = $this->container->get('router')->getContext();
                $context->setHost($site->getHost());
                $context->setScheme($site->getScheme());
                $context->setPathInfo($site->getRelativePath());

                $this->container->get('router')->setContext($context);
                var_dump($this->container->get('router')->generate('dashboard', [], UrlGeneratorInterface::ABSOLUTE_URL));


//                    throw new PageNotFoundException('Requested site not available for current user: ' .
//                        htmlspecialchars($this->container->get('request')->getUri(), ENT_QUOTES));
//                }
            }
        }
    }

    /**
     * Check sites match
     * @param SiteInterface $site
     * @return bool
     */
    protected function siteMatch(SiteInterface $site = null)
    {
        if (!is_null($site)) {
            if (($current = $this->container->get('sonata.page.site.selector')->retrieve())) {
                return $current->getId() == $site->getId();
            }
        }
        return true;
    }
}