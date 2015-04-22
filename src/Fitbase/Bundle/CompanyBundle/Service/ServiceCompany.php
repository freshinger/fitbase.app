<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 20/11/14
 * Time: 15:26
 */

namespace Fitbase\Bundle\CompanyBundle\Service;


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
     * Get focus for current user
     * @return null
     */
    public function current()
    {
        if (($user = $this->serviceUser->current())) {
            if (($company = $user->getCompany())) {
                if (strlen(($slug = $company->getSlug()))) {
                    $this->session->set('company', $company->getSlug());
                }
                return $company;
            }
        }

        if (strlen(($slug = $this->session->get('company')))) {
            if (($company = $this->companyManager->findOneBySlug($slug))) {
                return $company;
            }
        }

        return null;
    }
}