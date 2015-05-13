<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 20/11/14
 * Time: 15:26
 */

namespace Fitbase\Bundle\CompanyBundle\Service;


use Sonata\UserBundle\Model\UserInterface;

class ServiceCompany implements ServiceCompanyInterface
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

        return null;
    }
}