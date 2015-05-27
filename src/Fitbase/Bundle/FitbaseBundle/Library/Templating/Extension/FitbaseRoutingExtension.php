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
use Symfony\Component\Routing\RouterInterface;

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
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('url', array($this, 'getUrl'), array('is_safe_callback' => array($this, 'isUrlGenerationSafe'))),
            new \Twig_SimpleFunction('path', array($this, 'getPath'), array('is_safe_callback' => array($this, 'isUrlGenerationSafe'))),
            new \Twig_SimpleFunction('company_url', array($this, 'getUrlCompany'), array('is_safe_callback' => array($this, 'isUrlGenerationSafe'))),
        );
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
     * @param Company $company
     * @return string
     * @throws \Twig_Error_Runtime
     */
    public function getUrlCompany(Company $company, $name, $parameters = array())
    {
        return $this->container->get('company')->getCompanyUrl($company, $name, $parameters);
    }
}