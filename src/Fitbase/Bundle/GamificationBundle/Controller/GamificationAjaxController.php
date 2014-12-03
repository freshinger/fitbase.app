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
use Sonata\BlockBundle\Block\BlockContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GamificationAjaxController extends Controller
{
    /**
     * Load user tree using ajax
     * @param Request $request
     * @return Response
     */
    public function treeAction(Request $request)
    {
        return $this->render('FitbaseGamificationBundle:Ajax:dashboard_tree.html.twig', array());
    }

    /**
     * Load user tree using ajax
     * @param Request $request
     * @return Response
     */
    public function forestAction(Request $request)
    {
        return $this->render('FitbaseGamificationBundle:Ajax:dashboard_forest.html.twig', array());
    }

    /**
     * Load user avatar block
     * @param Request $request
     * @return Response
     */
    public function avatarAction(Request $request)
    {
        return $this->render('FitbaseGamificationBundle:Ajax:dashboard_avatar.html.twig', array());
    }

    /**
     * Load user statistic block
     * @param Request $request
     * @return Response
     */
    public function statisticAction(Request $request)
    {
        return $this->render('FitbaseGamificationBundle:Ajax:dashboard_statistic.html.twig', array());
    }
}
