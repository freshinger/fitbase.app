<?php

namespace Fitbase\Bundle\CompanyBundle\Controller;

use Fitbase\Bundle\CompanyBundle\Entity\Company;
use Fitbase\Bundle\CompanyBundle\Entity\CompanyUser;
use Fitbase\Bundle\CompanyBundle\Event\CompanyEvent;
use Fitbase\Bundle\CompanyBundle\Event\CompanyUserEvent;
use Fitbase\Bundle\CompanyBundle\Form\CompanyForm;
use Fitbase\Bundle\CompanyBundle\Form\CompanyUserForm;
use Fitbase\Bundle\WordpressBundle\Controller\WordpressControllerAbstract;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Cookie;

class CompanyUserController extends Controller
{
    /**
     * Build user-defined styles
     *
     */
    public function styleAction()
    {
        $user = $this->get('fitbase_manager.user')->getCurrentUser();
        $company = $company = $this->get('fitbase_manager.company')->getUserCompany($user);

        if (empty($user)) {
            // TODO: replace to symfony way
            $companyId = isset($_COOKIE['company']) ? $_COOKIE['company'] : null;
            $company = $this->get('fitbase_manager.company')->getCompany($companyId);
        }

        return $this->render('FitbaseCompanyBundle:CompanyUser:style.html.twig', array(
            'colorHeader' => is_object($company) ? $company->getColorHeader() : null,
            'colorFooter' => is_object($company) ? $company->getColorFooter() : null,
            'colorBackground' => is_object($company) ? $company->getColorBackground() : null,
        ));
    }

    /**
     * Display list of companies
     *
     */
    public function updateAction()
    {
        $managerUser = $this->get('fitbase_manager.user');

        $user = $managerUser->getCurrentUser();
        $company = $managerUser->getCompany($user);

        if (($id = $this->get('request')->get('user_id'))) {
            if (($user = $managerUser->find($id))) {
                $company = $managerUser->getCompany($user);
            }
        }

        $entity = new CompanyUser();
        $entity->setUser($user);
        $entity->setCompany($company);

        $form = $this->createForm(new CompanyUserForm(), $entity);
        if (!$this->get('request')->isMethodSafe()) {
            $form->handleRequest($this->get('request'));
            if ($form->isValid()) {

                $event = new CompanyUserEvent($entity);
                $this->get('event_dispatcher')->dispatch('fitbase_company_user_update', $event);
                return;
            }
        }

        return $this->render('FitbaseCompanyBundle:CompanyUser:update.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}