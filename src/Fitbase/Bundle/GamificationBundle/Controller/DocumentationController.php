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

class DocumentationController extends Controller
{
    public function manualAction(Request $request)
    {
        if (!($user = $this->get('user')->current())) {
            throw new \LogicException('User object can not be empty');
        }

        $root = $this->get('kernel')->getRootDir() . '/../web';

        $manual = '/bundles/fitbasegamification/doc/MANUAL_mit_UW_neu.pdf';
        if ($user->getPrivatePerson()) {
            $manual = '/bundles/fitbasegamification/doc/MANUAL_ohne_UW.pdf';
        }

        return new Response(file_get_contents("{$root}{$manual}"), 200, array(
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="manual.pdf"'
        ));
    }
}
