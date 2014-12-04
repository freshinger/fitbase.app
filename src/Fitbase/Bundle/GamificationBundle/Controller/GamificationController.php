<?php

namespace Fitbase\Bundle\GamificationBundle\Controller;

use Fitbase\Bundle\GamificationBundle\Entity\GamificationDialogQuestion;
use Fitbase\Bundle\GamificationBundle\Entity\GamificationUserDialogAnswer;
use Fitbase\Bundle\GamificationBundle\Entity\GamificationUserEmotion;
use Fitbase\Bundle\GamificationBundle\Event\GamificationUserDialogAnswerEvent;
use Fitbase\Bundle\GamificationBundle\Event\GamificationUserEmotionEvent;
use Fitbase\Bundle\GamificationBundle\Form\GamificationUserDialogAnswerBooleanForm;
use Fitbase\Bundle\GamificationBundle\Form\GamificationUserDialogAnswerFeedbackForm;
use Fitbase\Bundle\GamificationBundle\Form\GamificationUserDialogAnswerFinishForm;
use Fitbase\Bundle\GamificationBundle\Form\GamificationUserDialogAnswerForm;
use Fitbase\Bundle\GamificationBundle\Form\GamificationUserDialogAnswerNoticeForm;
use Fitbase\Bundle\GamificationBundle\Form\GamificationUserDialogAnswerTextForm;
use Fitbase\Bundle\GamificationBundle\Form\GamificationUserDialogAnswerTrashForm;
use Fitbase\Bundle\GamificationBundle\Form\GamificationUserEmotionForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GamificationController extends Controller
{
    /**
     * Create custom form for gamification chat
     * @param GamificationDialogQuestion $question
     * @param GamificationUserDialogAnswer $answer
     * @return \Symfony\Component\Form\Form
     */
    protected function createFormGamification(GamificationDialogQuestion $question, GamificationUserDialogAnswer $answer)
    {
        switch ($question->getType()) {
            case 'text':
                $type = new GamificationUserDialogAnswerTextForm();
                $answer->setValue(1);

                break;
            case 'boolean':
                $type = new GamificationUserDialogAnswerBooleanForm();
                break;
            case 'notice':
                $type = new GamificationUserDialogAnswerNoticeForm();
                $answer->setValue(1);
                break;
            case 'feedback':
                $type = new GamificationUserDialogAnswerFeedbackForm();
                $type->setContainer($this->container);
                $answer->setValue(1);
                break;
            case 'finish':
                $type = new GamificationUserDialogAnswerFinishForm();
                $answer->setValue(1);
                break;
            case 'trash':
                $type = new GamificationUserDialogAnswerTrashForm();
                $answer->setValue(1);
                break;
            default:
                $type = new GamificationUserDialogAnswerFinishForm();
                $answer->setValue(1);
                break;
        }
        $answer->setQuestion($question);
        return $this->createForm($type, $answer);
    }

    /**
     * Get question
     * @param $collection
     * @return mixed
     */
    protected function getQuestion($collection)
    {
        if (count($collection)) {
            if (($answer = end($collection))) {
                if (($question = $answer->getQuestion())) {
                    if ($question->getType() == 'boolean') {
                        if ($answer->getValue()) {
                            return $question->getQuestionTrue();
                        }
                        return $question->getQuestionFalse();
                    }
                    return $question->getQuestionTrue();
                }
            }

            return null;
        }

        $entityManager = $this->get('entity_manager');
        $repositoryGamificationDialogQuestion = $entityManager->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationDialogQuestion');
        return $repositoryGamificationDialogQuestion->findOneByStart();
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function healthEmotionAction(Request $request)
    {
        if (($user = $this->get('user')->current())) {

            $repositoryGamificationUserEmotion = $this->get('entity_manager')
                ->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUserEmotion');

            $datetime = $this->get('datetime')->getDateTime('now');
            if (!($emotion = $repositoryGamificationUserEmotion->findOneByUserAndDate($user, $datetime))) {

                $emotion = new GamificationUserEmotion();
                $emotion->setUser($user);
                $emotion->setDate($datetime);

                $form = $this->createForm(new GamificationUserEmotionForm(), $emotion);
                if ($request->get($form->getName())) {
                    $form->handleRequest($request);
                    if ($form->isValid()) {

                        $event = new GamificationUserEmotionEvent($emotion);
                        $this->get('event_dispatcher')->dispatch('gamification_user_emotion_done', $event);

                        return $this->render('FitbaseGamificationBundle:Gamification:health_emotion_done.html.twig', array(
                            'emotion' => $emotion
                        ));
                    }
                }

                return $this->render('FitbaseGamificationBundle:Gamification:health_emotion.html.twig', array(
                    'form' => $form->createView()
                ));
            }

            return $this->render('FitbaseGamificationBundle:Gamification:health_emotion_done.html.twig', array(
                'emotion' => $emotion
            ));
        }
    }

    /**
     * Display user chat with avatar
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function healthChatAction(Request $request)
    {
        $entityManager = $this->get('entity_manager');
        if (($user = $this->get('user')->current())) {
            $datetime = $this->get('datetime')->getDateTime('now');
            $repositoryGamificationUserDialogAnswer = $entityManager->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUserDialogAnswer');
            $collection = $repositoryGamificationUserDialogAnswer->findAllByUserAndDate($user, $datetime);
            if (($question = $this->getQuestion($collection))) {
                return $this->healthChatFormAction($request, $user, $question, $collection);
            }
            return $this->render('FitbaseGamificationBundle:Gamification:health_chat_done.html.twig', array(
                'question' => $question,
                'collection' => $collection,
            ));
        }
    }

    /**
     * Display chat form
     * @param Request $request
     * @param $user
     * @param $question
     * @param array $answers
     * @return Response
     */
    protected function healthChatFormAction(Request $request, $user, $question, $answers = array())
    {
        $userAnswer = new GamificationUserDialogAnswer();
        // Store user answer here using
        // chain responsibility
        $userAnswer->setUser($user);
        $userAnswer->setQuestion($question);
        $userAnswer->setDate($this->get('datetime')->getDateTime('now'));

        $form = $this->createFormGamification($question, $userAnswer);
        if ($request->get($form->getName())) {
            $form->handleRequest($request);
            if ($form->isValid()) {


                $gamificationDialogUserAnswerEvent = new GamificationUserDialogAnswerEvent($userAnswer);
                $this->get('event_dispatcher')->dispatch('gamification_dialog_user_answer_create', $gamificationDialogUserAnswerEvent);

                if ($question->getType() == 'trash') {
                    $gamificationDialogUserAnswerEvent = new GamificationUserDialogAnswerEvent($userAnswer);
                    $this->get('event_dispatcher')->dispatch('gamification_dialog_user_answer_hide_collection', $gamificationDialogUserAnswerEvent);
                }

                array_push($answers, $userAnswer);

                if (($question = $this->getQuestion($answers))) {

                    $userAnswerNew = new GamificationUserDialogAnswer();
                    $userAnswerNew->setUser($user);
                    $userAnswerNew->setQuestion($question);
                    $userAnswerNew->setDate($this->get('datetime')->getDateTime('now'));

                    if ($question->getType() == 'finish') {
                        $event = new GamificationUserDialogAnswerEvent($userAnswerNew);
                        $this->get('event_dispatcher')->dispatch('gamification_dialog_user_answer_done', $event);
                    }

                    $form = $this->createFormGamification($question, $userAnswerNew);
                    return $this->render('FitbaseGamificationBundle:Gamification:health_chat_next.html.twig', array(
                        'form' => $form->createView(),
                        'question' => $question,
                        'collection' => array($userAnswer),
                    ));
                }
                return $this->render('FitbaseGamificationBundle:Gamification:health_chat_done.html.twig', array());
            }
        }

        return $this->render('FitbaseGamificationBundle:Gamification:health_chat.html.twig', array(
            'form' => $form->createView(),
            'question' => $question,
            'collection' => $answers,
        ));
    }
}
