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

        $siteSelector = $this->container->get('sonata.page.site.selector');
        if (($site = $siteSelector->retrieve())) {
            if (($company = $this->companyManager->findOneBySite($site))) {
                return $company;
            }
        }

        return null;
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
}