<?php

namespace Fitbase\Bundle\GamificationBundle\Controller;

use Fitbase\Bundle\GamificationBundle\Entity\GamificationDialogQuestion;
use Fitbase\Bundle\GamificationBundle\Event\GamificationDialogQuestionEvent;
use Fitbase\Bundle\GamificationBundle\Form\GamificationDialogQuestionBooleanForm;
use Fitbase\Bundle\GamificationBundle\Form\GamificationDialogQuestionCreateForm;
use Fitbase\Bundle\GamificationBundle\Form\GamificationDialogQuestionFeedbackForm;
use Fitbase\Bundle\GamificationBundle\Form\GamificationDialogQuestionFinishForm;
use Fitbase\Bundle\GamificationBundle\Form\GamificationDialogQuestionForm;
use Fitbase\Bundle\GamificationBundle\Form\GamificationDialogQuestionNoticeForm;
use Fitbase\Bundle\GamificationBundle\Form\GamificationDialogQuestionTextForm;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdministrationController extends Controller
{
    /**
     * Display administration interface
     * @param Request $request
     * @return Response
     */
    public function listAction(Request $request)
    {
        if (($unique = $request->get('question_id_edit'))) {
            return $this->updateAction($request, $unique);
        }

        if (($unique = $request->get('question_id_remove'))) {
            return $this->removeAction($request, $unique);
        }

        $repositoryGamificationDialogQuestion = $this->get('fitbase_entity_manager')
            ->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationDialogQuestion');

        $pagerfanta = new Pagerfanta(new DoctrineORMAdapter(
            $repositoryGamificationDialogQuestion->findAllQueryBuilder()
        ));

        $pagerfanta->setMaxPerPage(50);
        $pagerfanta->setCurrentPage($request->get('navigate', 1));

        $question = new GamificationDialogQuestion();

        $form = $this->createForm(new GamificationDialogQuestionCreateForm(), $question);
        if ($request->get($form->getName())) {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $eventGamificationDialogQuestion = new GamificationDialogQuestionEvent($form->getData());
                $this->get('event_dispatcher')->dispatch('gamification_dialog_question_create', $eventGamificationDialogQuestion);

                $this->get('session')->getFlashBag()->add('notice', 'Eine neue Frage wurden erfolgreich angelget.');

                return $this->redirect("?page=gamification&question_id_edit={$question->getId()}");
            }
        }

        return $this->render('FitbaseGamificationBundle:Administration:list.html.twig', array(
            'pagerfanta' => $pagerfanta,
            'form' => $form->createView(),
            'flashbag' => $this->get('session')->getFlashBag(),
        ));
    }

    /**
     * Get correct form type
     * @param $gamificationDialogQuestion
     * @return GamificationDialogQuestionBooleanForm|GamificationDialogQuestionCreateForm|GamificationDialogQuestionFinishForm|GamificationDialogQuestionNoticeForm|GamificationDialogQuestionTextForm
     */
    protected function getGamificationDialogQuestionForm($gamificationDialogQuestion)
    {
        switch ($gamificationDialogQuestion->getType()) {
            case 'text':
                return new GamificationDialogQuestionTextForm();
            case 'boolean':
                return new GamificationDialogQuestionBooleanForm();
            case 'notice':
                return new GamificationDialogQuestionNoticeForm();
            case 'feedback':
                return new GamificationDialogQuestionFeedbackForm();
            case 'trash':
                return new GamificationDialogQuestionNoticeForm();
            case 'finish':
                return new GamificationDialogQuestionFinishForm();
            default:
                return new GamificationDialogQuestionCreateForm();
        }
    }

    /**
     * Remove question
     * @param Request $request
     * @param $unique
     * @return \Fitbase\Bundle\WordpressBundle\Controller\RedirectResponse
     */
    public function removeAction(Request $request, $unique)
    {
        $repositoryGamificationDialogQuestion = $this->get('fitbase_entity_manager')
            ->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationDialogQuestion');

        $gamificationDialogQuestion = $repositoryGamificationDialogQuestion->find($unique);

        $eventGamificationDialogQuestion = new GamificationDialogQuestionEvent($gamificationDialogQuestion);
        $this->get('event_dispatcher')->dispatch('gamification_dialog_question_remove', $eventGamificationDialogQuestion);

        $this->get('session')->getFlashBag()->add('notice', 'Die Frage wurde erfolgreich gelöscht.');

        return $this->redirect('?page=gamification');
    }

    /**
     * Process question update request
     * @param Request $request
     * @param $unique
     * @return Response
     */
    public function updateAction(Request $request, $unique)
    {
        $repositoryGamificationDialogQuestion = $this->get('fitbase_entity_manager')
            ->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationDialogQuestion');

        $gamificationDialogQuestion = $repositoryGamificationDialogQuestion->find($unique);

        $form = $this->createForm($this->getGamificationDialogQuestionForm($gamificationDialogQuestion), $gamificationDialogQuestion);
        if ($request->get($form->getName())) {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $eventGamificationDialogQuestion = new GamificationDialogQuestionEvent($gamificationDialogQuestion);
                $this->get('event_dispatcher')->dispatch('gamification_dialog_question_update', $eventGamificationDialogQuestion);

                $this->get('session')->getFlashBag()->add('notice', 'Die Frage wurde erfolgreich geshpeichert.');

                $form = $this->createForm($this->getGamificationDialogQuestionForm($gamificationDialogQuestion), $gamificationDialogQuestion);
            }
        }

        return $this->render('FitbaseGamificationBundle:Administration:update.html.twig', array(
            'form' => $form->createView(),
            'flashbag' => $this->get('session')->getFlashBag(),
        ));
    }

}
