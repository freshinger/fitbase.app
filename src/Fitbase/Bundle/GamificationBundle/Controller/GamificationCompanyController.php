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
use Fitbase\Bundle\GamificationBundle\Form\GamificationUserDialogAnswerHiddenForm;
use Fitbase\Bundle\GamificationBundle\Form\GamificationUserDialogAnswerNoticeForm;
use Fitbase\Bundle\GamificationBundle\Form\GamificationUserDialogAnswerTextForm;
use Fitbase\Bundle\GamificationBundle\Form\GamificationUserDialogAnswerAbstractForm;
use Fitbase\Bundle\GamificationBundle\Form\GamificationUserDialogAnswerTrashForm;
use Fitbase\Bundle\GamificationBundle\Form\GamificationUserEmotionForm;
use Fitbase\Bundle\WordpressBundle\Controller\WordpressControllerAbstract;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GamificationCompanyController extends WordpressControllerAbstract
{
    protected $user = null;
    protected $company = null;

    /**
     * Check for existed
     * @param $name
     * @param $arguments
     * @return mixed|Response
     */
    public function __call($name, $arguments)
    {
        if ($this->user == null) {

            $this->user = $this->get('fitbase_manager.user')->getCurrentUser();

            if ($this->company == null) {

                $managerEntity = $this->container->get('fitbase_entity_manager');
                $repositoryCompany = $managerEntity->getRepository('Fitbase\Bundle\CompanyBundle\Entity\Company');
                $this->company = $repositoryCompany->findOneByUser($this->user);
            }
        }

        if ($this->user != null) {
            // If company exists
            // and gamification disabled
            // return empty response for protected and
            // private methods
            if ($this->company != null) {
                if (!$this->company->getGamification()) {
                    return new Response('');
                }
            }
        }

        return call_user_func_array(array($this, $name), $arguments);
    }

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

//                $answer->setDescription('No description required');

                break;
            case 'notice':
                $type = new GamificationUserDialogAnswerNoticeForm();

                $answer->setValue(1);
//                $answer->setDescription('No description required');

                break;
            case 'feedback':
                $type = new GamificationUserDialogAnswerFeedbackForm();
                $type->setContainer($this->container);

                $answer->setValue(1);
//                $answer->setDescription('No description required');

                break;
            case 'finish':
                $type = new GamificationUserDialogAnswerFinishForm();

                $answer->setValue(1);
//                $answer->setDescription('No description required');

                break;
            case 'trash':
                $type = new GamificationUserDialogAnswerTrashForm();

                $answer->setValue(1);
//                $answer->setDescription('No description required');

                break;
            default:
                $type = new GamificationUserDialogAnswerFinishForm();

                $answer->setValue(1);
//                $answer->setDescription('No description required');

                break;
        }
        $answer->setQuestion($question);
        return $this->createForm($type, $answer);
    }

}
