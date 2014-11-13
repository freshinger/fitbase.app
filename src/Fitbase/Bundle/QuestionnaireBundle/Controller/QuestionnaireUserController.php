<?php

namespace Fitbase\Bundle\QuestionnaireBundle\Controller;

use Fitbase\Bundle\QuestionnaireBundle\Constraint\QuestionSection;
use Fitbase\Bundle\QuestionnaireBundle\Entity\Extra;
use Fitbase\Bundle\QuestionnaireBundle\Entity\Focus;
use Fitbase\Bundle\QuestionnaireBundle\Entity\Password;
use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserAnswer;
use Fitbase\Bundle\QuestionnaireBundle\Event\ExtraEvent;
use Fitbase\Bundle\QuestionnaireBundle\Event\FocusEvent;
use Fitbase\Bundle\QuestionnaireBundle\Event\PasswordEvent;
use Fitbase\Bundle\QuestionnaireBundle\Event\QuestionnaireUserAnswerEvent;
use Fitbase\Bundle\QuestionnaireBundle\Event\QuestionnaireUserEvent;
use Fitbase\Bundle\QuestionnaireBundle\Event\SectionEvent;
use Fitbase\Bundle\QuestionnaireBundle\Form\Constraint\QuestionnaireQuestionConstraint;
use Fitbase\Bundle\QuestionnaireBundle\Form\ExtraForm;
use Fitbase\Bundle\QuestionnaireBundle\Form\FocusForm;
use Fitbase\Bundle\QuestionnaireBundle\Form\PasswordForm;
use Fitbase\Bundle\QuestionnaireBundle\Form\QuestionnaireUserForm;
use Fitbase\Bundle\QuestionnaireBundle\Form\QuestionSectionForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class QuestionnaireUserController extends Controller
{
    /**
     * Check is needs to display questionnaire form
     * @param $user
     * @return bool
     */
    protected function isDisplayQuestionnaire($user)
    {
        return !$this->isDisplayPasswordReset($user);
    }

    /**
     * Check is needs to reset password
     * @param $user
     * @return bool
     */
    protected function isDisplayPasswordReset($user)
    {
        if (!empty($user)) {
            return !$user->getMetaValue('user_questionnaire_completed');
        }
        return false;
    }

    /**
     * Display user questionnaire
     * @param Request $request
     * @return Response
     */
    public function questionnaireAction(Request $request)
    {
        $user = $this->get('user')->current();
        if (empty($user) or !$this->isDisplayQuestionnaire($user)) {
            return new Response('');
        }

        $managerEntity = $this->get('entity_manager');
        $repositoryQuestionnaireUser = $managerEntity->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser');
        $repositoryQuestionnaireAnswer = $managerEntity->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireAnswer');
        $repositoryQuestionnaireQuestion = $managerEntity->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireQuestion');

        if (!($questionnaireUser = $repositoryQuestionnaireUser->findOneByUserAndNotDone($user))) {
            // No existed questionnaire
            // for current user
            return new Response('');
        }

        $formBuilder = new QuestionnaireUserForm();
        $formBuilder->setContainer($this->container);
        $formBuilder->setQuestionnaireUser($questionnaireUser);

        $form = $this->createForm($formBuilder, array());
        if ($request->get($form->getName())) {
            $form->handleRequest($request);

            $validator = $this->get('validator');
            foreach ($form as $child) {
                $errors = $validator->validateValue($child->getData(), new QuestionnaireQuestionConstraint());
                foreach ($errors as $error) {
                    $child->addError(new FormError($error->getMessage()));
                }
            }


            if ($form->isValid()) {

                // Set default point count
                // for heals and strain parameters
                $pointHealthTotal = 0;
                $pointStrainTotal = 0;


                foreach ($form->getData() as $questionId => $answerId) {

                    $pointHealth = 0;
                    $pointStrain = 0;

                    if (!($questionnaireQuestion = $repositoryQuestionnaireQuestion->find($questionId))) {
                        // If no questionnaire question
                        // found, write that in log file and break up
                        $this->get('logger')->info('Questionnaire done, question not found', array($questionId));
                        continue;
                    }

                    $questionnaireUserAnswer = new QuestionnaireUserAnswer();
                    $questionnaireUserAnswer->setUser($questionnaireUser->getUser());
                    $questionnaireUserAnswer->setQuestion($questionnaireQuestion);
                    $questionnaireUserAnswer->setQuestionnaireUser($questionnaireUser);
                    // check is answer selected
                    // and answer is a object(radio, slider)
                    // or array of objects (checkbox)
                    if (is_numeric($answerId) or is_array($answerId)) {

                        if (($questionnaireAnswer = $repositoryQuestionnaireAnswer->find($answerId))) {

                            if (is_array($questionnaireAnswer)) {
                                foreach ($questionnaireAnswer as $answer) {
                                    $pointHealth += $answer->getCountPointHealth();
                                    $pointStrain += $answer->getCountPointStrain();
                                }
                            } else {
                                $pointHealth = $questionnaireAnswer->getCountPointHealth();
                                $pointStrain = $questionnaireAnswer->getCountPointStrain();
                            }

                            $questionnaireUserAnswer->setAnswers($questionnaireAnswer);
                            $questionnaireUserAnswer->setCountPointHealth($pointHealth);
                            $questionnaireUserAnswer->setCountPointStrain($pointStrain);
                        }
                        // Check is answer is a text
                        // that means a text field
                    } else {
                        $questionnaireUserAnswer->setText($answerId);
                        $questionnaireUserAnswer->setCountPointHealth(0);
                        $questionnaireUserAnswer->setCountPointStrain(0);
                    }

                    // Increase total point count
                    // for health and strain for User Questionnaire object
                    $pointHealthTotal += $pointHealth;
                    $pointStrainTotal += $pointStrain;

                    $eventQuestionnaireUserAnswer = new QuestionnaireUserAnswerEvent($questionnaireUserAnswer);
                    $this->get('event_dispatcher')->dispatch('questionnaire_user_answer_create', $eventQuestionnaireUserAnswer);
                }

                $questionnaireUser->setCountPointHealth($pointHealthTotal);
                $questionnaireUser->setCountPointStrain($pointStrainTotal);

                $eventQuestionnaireUser = new QuestionnaireUserEvent($questionnaireUser);
                $this->get('event_dispatcher')->dispatch('questionnaire_user_done', $eventQuestionnaireUser);

                return $this->render('FitbaseQuestionnaireBundle:QuestionnaireUser:questionnaire_done.html.twig', array(
                    'questionnaire' => $questionnaireUser->getQuestionnaire(),
                    'questionnaireUser' => $questionnaireUser,
                ));

            }
        }

        return $this->render('FitbaseQuestionnaireBundle:QuestionnaireUser:questionnaire.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
            'questionnaire' => $questionnaireUser->getQuestionnaire(),
        ));
    }


    /**
     * Display password form
     * TODO: remove code duplication
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function passwordAction(Request $request)
    {
        if (($user = $this->get('user')->current())) {
            if ($this->isDisplayPasswordReset($user)) {

                $form = $this->createForm(new PasswordForm(), new Password());
                return $this->render('FitbaseQuestionnaireBundle:QuestionnaireUser:password.html.twig', array(
                    'user' => $this->get('user')->current(),
                    'form' => $form->createView(),
                ));
            }
        }

        return new Response('');
    }

    /**
     * Process password form
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function passwordSubmitAction(Request $request)
    {
        $request = $this->get('request');

        $this->get('logger')->info('Password popup submit, start');

        // Process only post- requests
        // ignore all other requests
        if (!$request->isMethodSafe()) {

            $this->get('logger')->info('Password popup submit, post');

            if (($user = $this->get('user')->current())) {
                if ($this->isDisplayPasswordReset($user)) {

                    $this->get('logger')->info('Password popup submit, display form');

                    $form = $this->createForm(new PasswordForm(), new Password());
                    if ($request->get($form->getName())) {
                        $form->handleRequest($request);
                        if ($form->isValid()) {

                            $this->get('logger')->info('Password popup submit, valid');

                            $event = new PasswordEvent($form->getData());
                            $this->get('event_dispatcher')->dispatch('questionnaire_password', $event);

                            $event = new Event();
                            $event->entity = $user;
                            $this->get('event_dispatcher')->dispatch('questionnaire_done', $event);

                            return $this->redirect("/mitgliederbereich/");
                        }
                    }

                }
            }
        }

        return null;
    }

//    /**
//     * Display welcome page
//     * @return \Symfony\Component\HttpFoundation\Response
//     */
//    public function questionnaireAction()
//    {
//        $request = $this->get('request');
//        $modalPage = $request->get('questionnaire', null);
//        $userManager = $this->get('user');
//
//        if (($user = $userManager->current())) {
////            if (!$user->getMetaValue('user_questionnaire_completed'))
//            {
////                if (($company = $userManager->getCompany($user)))
//                {
////                    if ($company->getQuestionnaire())
//                    {
//                        switch ($modalPage) {
//                            case 'result':
//                                // Display statistic page with
//                                // percent, and other common information
//                                return $this->resultAction($request);
//                            case 'extra':
//                                // Choose a RSI, Thera band
//                                // and Augen,
//                                return $this->extraAction($request);
//
//                            case 'focus':
//                                // Choose a user-focus
//                                // from 2 variants
//                                return $this->focusAction($request);
//
//                            case 'section':
//                                // Display a questions from database
//                                // build questions dynamically
//                                return $this->sectionAction($request);
//                        }
//                    }
//                }
//
//                switch ($modalPage) {
//                    case 'password':
//                        // Change a user password
//                        // have to create new after login
//                        return $this->passwordAction($request);
//                    default:
//                        // Just a welcome page
//                        // without forms and so on
//                        return $this->welcomeAction($request);
//                }
//            }
//        }
//
//        return new Response('', 200);
//    }

//    /**
//     * Process questionnaire forms
//     * @return \Symfony\Component\HttpFoundation\RedirectResponse
//     */
//    public function questionnaireProcessAction()
//    {
//        $request = $this->get('request');
//        // Process questions from database
//        // show questions by section, if no section exists
//        // go to next step
//        if (($response = $this->passwordSubmitAction($request))) {
//            return $response;
//        }
//        // Process question from sections,
//        // go to next step if all is ok
//        if (($response = $this->sectionSubmitAction($request))) {
//            return $response;
//        }
//        // Save a focus result
//        // go to next step after submit
//        if (($response = $this->focusSubmitAction($request))) {
//            return $response;
//        }
//        // Save extra features
//        // go to result page after submit
//        if (($response = $this->extraSubmitAction($request))) {
//            return $response;
//        }
//    }


//    /**
//     * Display interface to choose a focus
//     * TODO: finish page logic
//     * @param Request $request
//     * @return \Symfony\Component\HttpFoundation\Response
//     */
//    public function resultAction(Request $request)
//    {
//        $user = $this->get('user')->current();
//
//        $wordpress = $this->container->get('fitbase_wordpress.api');
//
//        $focus = $wordpress->wpGetUserMeta($user->getId(), 'user_exercise_focus', true);
//        $au = $wordpress->wpGetUserMeta($user->getId(), 'user_exercise_eye', true);
//        $rs = $wordpress->wpGetUserMeta($user->getId(), 'user_exercise_rsi', true);
//        $th = $wordpress->wpGetUserMeta($user->getId(), 'user_exercise_thera', true);
//
//        $repositoryQuestion = $this->get('entity_manager')
//            ->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\Result');
//
//        $event = new Event();
//        $event->entity = $user;
//        $this->get('event_dispatcher')->dispatch('questionnaire_done', $event);
//
//        return $this->render('FitbaseQuestionnaireBundle:QuestionnaireUser:result.html.twig', array(
//            'au' => $au,
//            'rs' => $rs,
//            'th' => $th,
//            'percentage1' => $repositoryQuestion->getHealthPercentage($user, 1),
//            'percentage2' => $repositoryQuestion->getHealthPercentage($user, 2),
//            'focus' => $focus,
//        ));
//    }
//
//    /**
//     * Display interface to choose a focus
//     * TODO: remove code duplication
//     * @param Request $request
//     * @return \Symfony\Component\HttpFoundation\Response
//     */
//    public function extraAction(Request $request)
//    {
//        $user = $this->get('user')->current();
//
//        $wordpress = $this->container->get('fitbase_wordpress.api');
//
//        $entity = new Extra();
//        $entity->setAu($wordpress->wpGetUserMeta($user->getId(), 'user_exercise_eye', true));
//        $entity->setRs($wordpress->wpGetUserMeta($user->getId(), 'user_exercise_rsi', true));
//        $entity->setTh($wordpress->wpGetUserMeta($user->getId(), 'user_exercise_thera', true));
//
//        $form = $this->createForm(new ExtraForm(), $entity);
//        if (!$request->isMethodSafe()) {
//            $form->handleRequest($request);
//            $form->isValid();
//        }
//
//        return $this->render('FitbaseQuestionnaireBundle:QuestionnaireUser:extra.html.twig', array(
//            'form' => $form->createView()
//        ));
//    }

//    /**
//     * Submit extra form
//     * @param Request $request
//     * @return \Symfony\Component\HttpFoundation\RedirectResponse
//     */
//    public function extraSubmitAction(Request $request)
//    {
//        $form = $this->createForm(new ExtraForm(), new Extra());
//        if (!$request->isMethodSafe()) {
//            if ($request->get($form->getName())) {
//                $form->handleRequest($request);
//
//                if ($form->isValid()) {
//
//                    $event = new ExtraEvent($form->getData());
//                    $this->get('event_dispatcher')->dispatch('questionnaire_extra', $event);
//
//                    return $this->redirect("?questionnaire=result");
//                }
//            }
//        }
//
//        return null;
//    }

//    /**
//     * Display interface to choose a focus
//     * TODO: remove code duplication
//     * @param Request $request
//     * @return \Symfony\Component\HttpFoundation\Response
//     */
//    public function focusAction(Request $request)
//    {
//        $user = $this->get('user')->current();
//
//        $wordpress = $this->container->get('fitbase_wordpress.api');
//
//        $entity = new Focus();
//        $entity->setFocus($wordpress->wpGetUserMeta($user->getId(), 'user_exercise_focus', true));
//
//        $form = $this->createForm(new FocusForm(), $entity);
//        if (!$request->isMethodSafe()) {
//            $form->handleRequest($request);
//            $form->isValid();
//        }
//
//        return $this->render('FitbaseQuestionnaireBundle:QuestionnaireUser:focus.html.twig', array(
//            'form' => $form->createView(),
//        ));
//    }

//    /**
//     * Save user focus result
//     * @param Request $request
//     * @return \Symfony\Component\HttpFoundation\RedirectResponse
//     */
//    public function focusSubmitAction(Request $request)
//    {
//        $form = $this->createForm(new FocusForm(), new Focus());
//        if (!$request->isMethodSafe()) {
//            if ($request->get($form->getName())) {
//                $form->handleRequest($request);
//                if ($form->isValid()) {
//
//                    $event = new FocusEvent($form->getData());
//                    $this->get('event_dispatcher')->dispatch('questionnaire_focus', $event);
//
//                    return $this->redirect("?questionnaire=extra");
//                }
//            }
//        }
//        return null;
//    }

//    /**
//     * Get questionnaire section page
//     * TODO: remove code duplication
//     * @param Request $request
//     * @return \Symfony\Component\HttpFoundation\Response
//     */
//    public function sectionAction(Request $request)
//    {
//        $section = (int)$request->get('section');
//
//        $formBuilder = new QuestionSectionForm($this->container, $section);
//        $form = $this->createForm($formBuilder, array());
//        if (!$request->isMethodSafe()) {
//            $form->handleRequest($request);
//            $errors = $this->get('validator')
//                ->validateValue($form->getData(), new QuestionSection());
//
//            if (count($errors)) {
//                foreach ($errors as $error) {
//                    $form->addError(new FormError($error->getMessage()));
//                }
//            }
//        }
//
//        return $this->render('FitbaseQuestionnaireBundle:QuestionnaireUser:section.html.twig', array(
//            'form' => $form->createView(),
//        ));
//    }
//
//    /**
//     * Process section form submit
//     * @param Request $request
//     * @return \Symfony\Component\HttpFoundation\RedirectResponse
//     */
//    public function sectionSubmitAction(Request $request)
//    {
//        $section = (int)$request->get('section');
//
//        $formBuilder = new QuestionSectionForm($this->container, $section);
//        $form = $this->createForm($formBuilder, array());
//        if (!$request->isMethodSafe()) {
//            if ($request->get($form->getName())) {
//                $form->handleRequest($request);
//
//                $errors = $this->get('validator')
//                    ->validateValue($form->getData(), new QuestionSection());
//
//                if (!count($errors)) {
//
//                    $event = new SectionEvent($form->getData());
//                    $this->get('event_dispatcher')->dispatch('questionnaire_section', $event);
//
//                    $section += 1;
//                    $repositoryQuestion = $this->get('entity_manager')
//                        ->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\Question');
//
//                    if ($repositoryQuestion->isSectionExists($section)) {
//                        return $this->redirect("?questionnaire=section&section=$section");
//                    }
//
//                    return $this->redirect("?questionnaire=focus");
//                }
//            }
//        }
//        return null;
//    }

    /**
     * Display welcome page
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function welcomeAction(Request $request)
    {
        return $this->render('FitbaseQuestionnaireBundle:QuestionnaireUser:welcome.html.twig', array(
            'user' => $this->get('user')->current()
        ));
    }
}
