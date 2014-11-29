<?php

namespace Fitbase\Bundle\CompanyBundle\Controller;

use Fitbase\Bundle\CompanyBundle\Entity\Company;
use Fitbase\Bundle\CompanyBundle\Event\CompanyEvent;
use Fitbase\Bundle\CompanyBundle\Form\CompanyForm;
use Fitbase\Bundle\CompanyBundle\Form\CompanyQuestionnaireForm;
use Fitbase\Bundle\WordpressBundle\Controller\WordpressControllerAbstract;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CompanyController extends Controller
{
    public function listAction(Request $request)
    {
        if (($unique = $request->get('company_id'))) {
            return $this->editAction($request, $unique);
        }

        $companies = $this->get('entity_manager')
            ->getRepository('Fitbase\Bundle\CompanyBundle\Entity\Company')
            ->findAll();

        return $this->render('FitbaseCompanyBundle:Company:list.html.twig', array(
            'page' => $this->get('request')->get('page'),
            'flashbag' => $this->get('session')->getFlashBag(),
            'companies' => $companies,
        ));
    }

    /**
     * Create company action
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(new CompanyForm(), new Company());
        if (!$this->get('request')->isMethodSafe()) {
            $form->handleRequest($this->get('request'));
            if ($form->isValid()) {

                $event = new CompanyEvent($form->getData());
                $this->get('event_dispatcher')->dispatch('fitbase_company_create', $event);

                $this->get('session')->getFlashBag()->add('notice', 'Ein neuen Unternehmen wurde erfolgreich hingefuegt.');
                return $this->redirect('?page=' . $this->get('request')->get('page'));
            }
        }

        return $this->render('FitbaseCompanyBundle:Company:update.html.twig', array(
            'form' => $form->createView(),
            'flashbag' => $this->get('session')->getFlashBag(),

        ));
    }

    /**
     * Update company data
     * @param $unique
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $unique)
    {
        $company = $this->get('entity_manager')
            ->find('Fitbase\Bundle\CompanyBundle\Entity\Company', $unique);

        $form = $this->createForm(new CompanyForm(), $company);
        if ($request->get($form->getName())) {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $event = new CompanyEvent($form->getData());
                $this->get('event_dispatcher')->dispatch('fitbase_company_update', $event);

                $this->get('session')->getFlashBag()->add('notice', 'Ein neuen Unternehmen wurde erfolgreich geaendert.');
                return $this->redirect('?page=' . $request->get('page'));
            }
        }

        $formQuestionnaire = $this->createForm(new CompanyQuestionnaireForm(), $company);
        if ($request->get($formQuestionnaire->getName())) {
            $formQuestionnaire->handleRequest($request);
            if ($formQuestionnaire->isValid()) {

                $event = new CompanyEvent($formQuestionnaire->getData());
                $this->get('event_dispatcher')->dispatch('fitbase_company_update', $event);

                $this->get('session')->getFlashBag()->add('notice', 'Ein neuen Unternehmen wurde erfolgreich geaendert.');
            }
        }

        $repositoryQuestionnaireCompany = $this->get('entity_manager')
            ->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireCompany');

        if (($uniqueRemove = $request->get('questionnaire_company_id_remove'))) {
            if (($entityQuestionnaireCompany = $repositoryQuestionnaireCompany->find($uniqueRemove))) {

                $eventQuestionnaireCompany = new \Fitbase\Bundle\QuestionnaireBundle\Event\QuestionnaireCompanyEvent($entityQuestionnaireCompany);
                $this->get('event_dispatcher')->dispatch('questionnaire_company_remove', $eventQuestionnaireCompany);

                $this->get('session')->getFlashBag()->add('notice', 'Ein neues Fragebogen für den Unternehmen wurde erfolgreich gelöscht.');
            }
        }

        $entityQuestionnaireCompany = new \Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireCompany();
        $entityQuestionnaireCompany->setCompany($company);

        $formQuestionnaireCompany = $this->createForm(new \Fitbase\Bundle\QuestionnaireBundle\Form\QuestionnaireCompanyForm(), $entityQuestionnaireCompany);
        if ($this->get('request')->get($formQuestionnaireCompany->getName())) {
            $formQuestionnaireCompany->handleRequest($this->get('request'));
            if ($formQuestionnaireCompany->isValid()) {

                $eventQuestionnaireCompany = new \Fitbase\Bundle\QuestionnaireBundle\Event\QuestionnaireCompanyEvent($entityQuestionnaireCompany);
                $this->get('event_dispatcher')->dispatch('questionnaire_company_create', $eventQuestionnaireCompany);

                $this->get('session')->getFlashBag()->add('notice', 'Ein neues Fragebogen für den Unternehmen wurde erfolgreich geaendert.');
            }
        }

        $questionnaries = $repositoryQuestionnaireCompany->findBy(array('company' => $company));

        return $this->render('FitbaseCompanyBundle:Company:edit.html.twig', array(
            'form' => $form->createView(),
            'formQuestionnaire' => $formQuestionnaire->createView(),
            'formQuestionnaireCompany' => $formQuestionnaireCompany->createView(),
            'collection' => $questionnaries,
            'flashbag' => $this->get('session')->getFlashBag(),
        ));
    }
}
