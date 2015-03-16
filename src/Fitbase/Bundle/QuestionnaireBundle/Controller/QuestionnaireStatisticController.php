<?php

namespace Fitbase\Bundle\QuestionnaireBundle\Controller;

use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireCompany;
use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser;
use Fitbase\Bundle\QuestionnaireBundle\Form\QuestionnaireUserForm;
use Fitbase\Bundle\UserBundle\Entity\UserFocus;
use Fitbase\Bundle\UserBundle\Entity\UserFocusCategory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class QuestionnaireStatisticController extends Controller
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
                $entity->setUser($user);
//                $entity->setUser(
//                    (new User())->setFocus(
//                        (new UserFocus())
//                            ->setCategories(
//                                $company->getCategories()->map(function ($companyCategory) {
//                                    return (new UserFocusCategory())
//                                        ->setCategory($companyCategory->getCategory());
//                                })
//                            )
//                    )
//                );
                $entity->setQuestionnaire($companyQuestionnaire);
                $form = $this->createForm(new QuestionnaireUserForm($this->container, $entity), array());

                return $this->render('FitbaseQuestionnaireBundle:QuestionnaireStatistic:questionnaire.html.twig', array(
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
                $entity->setSlice($questionnaireCompany);
                $entity->setQuestionnaire($questionnaireCompany->getQuestionnaire());

                $form = $this->createForm(new QuestionnaireUserForm($this->container, $entity), array());

                return $this->render('FitbaseQuestionnaireBundle:QuestionnaireStatistic:questionnaire_slice.html.twig', array(
                    'form' => $form->createView(),
                    'questionnaire' => $questionnaireCompany,
                ));
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
                return $this->render('FitbaseQuestionnaireBundle:QuestionnaireStatistic:questionnaire_preview.html.twig', array(
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
        if (($user = $this->get('user')->current())) {

            return $this->render('FitbaseQuestionnaireBundle:QuestionnaireStatistic:questionnaire_company.html.twig', array(
                'company' => $user->getCompany(),
            ));
        }
    }
}
