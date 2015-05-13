<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 12/05/15
 * Time: 13:56
 */

namespace Fitbase\Bundle\FitbaseBundle\Library\Templating\Extension;


use Fitbase\Bundle\CompanyBundle\Entity\Company;
use Symfony\Bridge\Twig\Extension\RoutingExtension;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class FitbaseRoutingExtension extends RoutingExtension implements ContainerAwareInterface
{


    protected $container;
    protected $generator;

    public function __construct(UrlGeneratorInterface $generator)
    {
        $this->generator = $generator;

        parent::__construct($generator);
    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Get url
     * @param $name
     * @param array $parameters
     * @param bool $schemeRelative
     * @param Company $company
     * @return string
     * @throws \Twig_Error_Runtime
     */
    public function getUrl($name, $parameters = array(), $schemeRelative = false, Company $company = null)
    {
//        if (is_null($company)) {
//            throw new \Twig_Error_Runtime("You have to put 'Company' to 'url' method to identify user available site");
//        }

        if (!empty($company) and ($site = $company->getSite())) {
            if (($context = $this->container->get('router')->getContext())) {
                // Base url have to be already defined
                // if not - console application, override
                // host, base url and other things
                if (!strlen($context->getBaseUrl())) {

                    if (!strlen($site->getScheme())) {
                        throw new \Twig_Error_Runtime("You have to define scheme for Site: '{$site->getName()}'");
                    }

                    if (!strlen($site->getHost())) {
                        throw new \Twig_Error_Runtime("You have to define Host for Site: '{$site->getName()}'");
                    }

                    if (!strlen($site->getRelativePath())) {
                        throw new \Twig_Error_Runtime("You have to define Relative Path for Site: '{$site->getName()}'");
                    }

                    $context->setHost($site->getHost());
                    $context->setScheme($site->getScheme());
                    $context->setBaseUrl($site->getRelativePath());
                }
            }
        }

        return $this->generator->generate($name, $parameters, $schemeRelative ? UrlGeneratorInterface::NETWORK_PATH : UrlGeneratorInterface::ABSOLUTE_URL);
    }


}