<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 20/11/14
 * Time: 15:26
 */

namespace Fitbase\Bundle\CompanyBundle\Service;


use Fitbase\Bundle\CompanyBundle\Entity\Company;
use Sonata\UserBundle\Model\UserInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ServiceCompany extends ContainerAware implements ServiceCompanyInterface
{
    protected $serviceUser;
    protected $companyManager;
    protected $session;

    /**
     * Class constructor
     * @param $serviceUser
     */
    public function __construct($serviceUser, $companyManager, $session)
    {
        $this->serviceUser = $serviceUser;
        $this->companyManager = $companyManager;
        $this->session = $session;
    }

    /**
     * Get focus for current user
     * @return null
     */
    public function current(UserInterface $user = null)
    {
        if (($user = is_null($user) ? $this->serviceUser->current() : $user)) {
            if (($company = $user->getCompany())) {
                $this->setCompanySlugCache($company);
                return $company;
            }
        }

        if (strlen(($slug = $this->getCompanySlugCache()))) {
            if (($company = $this->companyManager->findOneBySlug($slug))) {
                return $company;
            }
        }

        if (($site = $this->container->get('sonata.page.site.selector')->retrieve())) {
            if (($company = $this->companyManager->findOneBySite($site))) {
                return $company;
            }
        }

        return null;
    }

    /**
     * Set company cache for user
     * @param $company
     * @return bool
     */
    protected function setCompanySlugCache($company)
    {
        if (strlen(($slug = $company->getSlug()))) {
            $this->session->set('company', $company->getSlug());
            return true;
        }
        return false;
    }

    /**
     * Get cached company
     * @return mixed
     */
    protected function getCompanySlugCache()
    {
        return $this->session->get('company');
    }

    /**
     * Get url for current company
     * @param Company $company
     * @param $name
     * @param array $parameters
     * @return mixed
     * @throws \Twig_Error_Runtime
     */
    public function getCompanyUrl(Company $company, $name, $parameters = array())
    {
        if (($site = $company->getSite())) {
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

        return $this->container->get('router')->generate($name, $parameters, UrlGeneratorInterface::ABSOLUTE_URL);
    }

}