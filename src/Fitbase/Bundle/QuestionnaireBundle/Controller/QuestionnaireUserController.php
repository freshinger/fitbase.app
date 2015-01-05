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
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class QuestionnaireUserController extends Controller
{
//    /**
//     * Display user questionnaire
//     * @param Request $request
//     * @return Response
//     */
//    public function questionnaireAction(Request $request)
//    {
//        if (!($user = $this->get('user')->current())) {
//            throw new AccessDeniedException('This user does not have access to this section.');
//        }
//
//        $managerEntity = $this->get('entity_manager');
//        $repositoryQuestionnaireUser = $managerEntity->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser');
//        $repositoryQuestionnaireAnswer = $managerEntity->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireAnswer');
//        $repositoryQuestionnaireQuestion = $managerEntity->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireQuestion');
//
//        // No existed questionnaire
//        // for current user
//        if (!($questionnaireUser = $repositoryQuestionnaireUser->findOneByUserAndNotDone($user))) {
//            throw new AccessDeniedException('This user does not have access to this section.');
//        }
//
//        var_dump(get_class($questionnaireUser));
//
//        $formBuilder = new QuestionnaireUserForm($this->container, $questionnaireUser);
//
//        $form = $this->createForm($formBuilder, array());
//        if ($request->get($form->getName())) {
//            $form->handleRequest($request);
//
//            $validator = $this->get('validator');
//            foreach ($form as $child) {
//                $errors = $validator->validateValue($child->getData(), new QuestionnaireQuestionConstraint());
//                foreach ($errors as $error) {
//                    $child->addError(new FormError($error->getMessage()));
//                }
//            }
//
//
//            if ($form->isValid()) {
//
//                // Set default point count
//                // for heals and strain parameters
//                $pointHealthTotal = 0;
//                $pointStrainTotal = 0;
//
//
//                foreach ($form->getData() as $questionId => $answerId) {
//
//                    $pointHealth = 0;
//                    $pointStrain = 0;
//
//                    // If no questionnaire question
//                    // found, write that in log file and break up
//                    if (!($questionnaireQuestion = $repositoryQuestionnaireQuestion->find($questionId))) {
//                        $this->get('logger')->info('Questionnaire done, question not found', array($questionId));
//                        continue;
//                    }
//
//                    $questionnaireUserAnswer = new QuestionnaireUserAnswer();
//                    $questionnaireUserAnswer->setUser($questionnaireUser->getUser());
//                    $questionnaireUserAnswer->setQuestion($questionnaireQuestion);
//                    $questionnaireUserAnswer->setQuestionnaireUser($questionnaireUser);
//                    // check is answer selected
//                    // and answer is a object(radio, slider)
//                    // or array of objects (checkbox)
//                    if (is_numeric($answerId) or is_array($answerId)) {
//
//                        if (($questionnaireAnswer = $repositoryQuestionnaireAnswer->find($answerId))) {
//
//                            if (is_array($questionnaireAnswer)) {
//                                foreach ($questionnaireAnswer as $answer) {
//                                    $pointHealth += $answer->getCountPointHealth();
//                                    $pointStrain += $answer->getCountPointStrain();
//                                }
//                            } else {
//                                $pointHealth = $questionnaireAnswer->getCountPointHealth();
//                                $pointStrain = $questionnaireAnswer->getCountPointStrain();
//                            }
//
//                            $questionnaireUserAnswer->setAnswers($questionnaireAnswer);
//                            $questionnaireUserAnswer->setCountPointHealth($pointHealth);
//                            $questionnaireUserAnswer->setCountPointStrain($pointStrain);
//                        }
//                        // Check is answer is a text
//                        // that means a text field
//                    } else {
//                        $questionnaireUserAnswer->setText($answerId);
//                        $questionnaireUserAnswer->setCountPointHealth(0);
//                        $questionnaireUserAnswer->setCountPointStrain(0);
//                    }
//
//                    // Increase total point count
//                    // for health and strain for User Questionnaire object
//                    $pointHealthTotal += $pointHealth;
//                    $pointStrainTotal += $pointStrain;
//
//                    $eventQuestionnaireUserAnswer = new QuestionnaireUserAnswerEvent($questionnaireUserAnswer);
//                    $this->get('event_dispatcher')->dispatch('questionnaire_user_answer_create', $eventQuestionnaireUserAnswer);
//                }
//
//                $questionnaireUser->setCountPointHealth($pointHealthTotal);
//                $questionnaireUser->setCountPointStrain($pointStrainTotal);
//
//                $eventQuestionnaireUser = new QuestionnaireUserEvent($questionnaireUser);
//                $this->get('event_dispatcher')->dispatch('questionnaire_user_done', $eventQuestionnaireUser);
//
//                return $this->render('FitbaseQuestionnaireBundle:QuestionnaireUser:questionnaire_done.html.twig', array(
//                    'questionnaire' => $questionnaireUser->getQuestionnaire(),
//                    'questionnaireUser' => $questionnaireUser,
//                ));
//
//            }
//        }
//
//        return $this->render('FitbaseQuestionnaireBundle:QuestionnaireUser:questionnaire.html.twig', array(
//            'user' => $user,
//            'form' => $form->createView(),
//            'questionnaire' => $questionnaireUser->getQuestionnaire(),
//        ));
//    }
}
