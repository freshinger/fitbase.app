<?php

namespace Fitbase\Bundle\CompanyBundle\Controller;

use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireCompany;
use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser;
use Fitbase\Bundle\QuestionnaireBundle\Event\QuestionnaireCompanyEvent;
use Fitbase\Bundle\QuestionnaireBundle\Form\QuestionnaireUserForm;
use Fitbase\Bundle\UserBundle\Entity\UserFocus;
use Fitbase\Bundle\UserBundle\Entity\UserFocusCategory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class QuestionnaireController extends Controller
{
    /**
     *
     * @param Request $request
     * @param null $unique
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function questionnaireAction(Request $request, $unique = null)
    {
        $questions = null;

        if (($user = $this->get('user')->current()) and ($company = $user->getCompany())) {

            $entityManager = $this->get('entity_manager');
            $repositoryQuestionnaire = $entityManager->getRepository('Fitbase\Bundle\CompanyBundle\Entity\CompanyQuestionnaire');
            if (($companyQuestionnaire = $repositoryQuestionnaire->findOneByUniqueAndCompany($unique, $company))) {

                $entity = new QuestionnaireUser();
                $entity->setUser(
                    (new User())
                        ->setCompany($company)
                        ->setFocus(
                            (new UserFocus())
                                ->setCategories(
                                    $company->getCategories()->map(function ($companyCategory) {
                                        return (new UserFocusCategory())
                                            ->setCategory($companyCategory->getCategory());
                                    })
                                )
                        )
                );
                $entity->setQuestionnaire($companyQuestionnaire);
                $form = $this->createForm(new QuestionnaireUserForm($this->container, $entity), array());

                return $this->render('Company/Questionnaire/Questionnaire.html.twig', array(
                    'form' => $form->createView(),
                    'questionnaire' => $companyQuestionnaire,
                ));
            }
        }
    }

    /**
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function questionnaireSliceAction(Request $request, $unique = null)
    {
        $questions = null;

        if (($user = $this->get('user')->current()) and ($company = $user->getCompany())) {

            $entityManager = $this->get('entity_manager');
            $repositoryQuestionnaire = $entityManager->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireCompany');
            if (($questionnaireCompany = $repositoryQuestionnaire->findOneByUniqueAndCompany($unique, $company))) {

                $entity = new QuestionnaireUser();
                $entity->setUser($user);
                $entity->setUser(
                    (new User())
                        ->setCompany($company)
                        ->setFocus(
                            (new UserFocus())
                                ->setCategories(
                                    $company->getCategories()->map(function ($companyCategory) {
                                        return (new UserFocusCategory())
                                            ->setCategory($companyCategory->getCategory());
                                    })
                                )
                        )
                );
                $entity->setSlice($questionnaireCompany);
                $entity->setQuestionnaire($questionnaireCompany->getQuestionnaire());

                $form = $this->createForm(new QuestionnaireUserForm($this->container, $entity), array());

                return $this->render('Company/Questionnaire/QuestionnaireSlice.html.twig', array(
                    'form' => $form->createView(),
                    'questionnaire' => $questionnaireCompany,
                ));
            }
        }
    }

    /**
     * Remove current questionnaire slice
     *
     * @param Request $request
     * @param null $unique
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function questionnaireSliceRemoveAction(Request $request, $unique = null)
    {
        if (($company = $this->get('company')->current())) {

            $entityManager = $this->get('entity_manager');
            $repositoryQuestionnaire = $entityManager->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireCompany');
            if (($questionnaireCompany = $repositoryQuestionnaire->findOneByUniqueAndCompany($unique, $company))) {

                $event = new QuestionnaireCompanyEvent($questionnaireCompany);
                $this->get('event_dispatcher')->dispatch('fitbase.questionnaire_company_remove', $event);

                return $this->redirect($this->generateUrl('questionnaire_company'));
            }
        }
    }


    /**
     * Display questionnaire preview
     * @param Request $request
     * @param null $unique
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function questionnairePreviewAction(Request $request, $unique = null)
    {
        $questions = null;

        if (($user = $this->get('user')->current()) and ($company = $user->getCompany())) {

            $entityManager = $this->get('entity_manager');
            $repositoryQuestionnaire = $entityManager->getRepository('Fitbase\Bundle\CompanyBundle\Entity\CompanyQuestionnaire');
            if (($companyQuestionnaire = $repositoryQuestionnaire->findOneByUniqueAndCompany($unique, $company))) {

                $entity = new QuestionnaireUser();
                $entity->setQuestionnaire($companyQuestionnaire);
                $entity->setUser(
                    (new User())->setFocus(
                        (new UserFocus())
                            ->setCategories(
                                $company->getCategories()->map(function ($companyCategory) {
                                    return (new UserFocusCategory())
                                        ->setCategory($companyCategory->getCategory());
                                })
                            )
                    )
                );
                $entity->setSlice(
                    (new QuestionnaireCompany())
                        ->setCompany($company)
                        ->setQuestionnaire($companyQuestionnaire)
                        ->setProcessed(false)
                );

                $form = $this->createForm(new QuestionnaireUserForm($this->container, $entity), array());
                return $this->render('Company/Questionnaire/QuestionnairePreview.html.twig', array(
                    'form' => $form->createView(),
                    'questionnaire' => $companyQuestionnaire,
                ));
            }
        }
    }

    /**
     *
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function questionnaireCompanyAction(Request $request)
    {
        if (($company = $this->get('company')->current())) {

            return $this->render('Company/Questionnaire/Dashboard.html.twig', array(
                'company' => $company,
            ));
        }
    }
}
