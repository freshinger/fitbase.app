<?php

namespace Fitbase\Bundle\UserBundle\Controller;

use Fitbase\Bundle\UserBundle\Entity\ImportActioncode;
use Fitbase\Bundle\UserBundle\Entity\UserActioncode;
use Fitbase\Bundle\UserBundle\Entity\UserImport;
use Fitbase\Bundle\UserBundle\Entity\UserSearch;
use Fitbase\Bundle\UserBundle\Entity\Import;

use Fitbase\Bundle\UserBundle\Event\UserImportEvent;
use Fitbase\Bundle\UserBundle\Form\ImportActioncodeForm;
use Fitbase\Bundle\UserBundle\Form\ImportForm;
use Fitbase\Bundle\UserBundle\Form\UserSearchForm;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Sonata\AdminBundle\Controller\CoreController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Exception\LogicException;
use Symfony\Component\Form\FormError;


class AdminController extends CoreController
{
    /**
     *
     * @param Request $request
     * @param $unique
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function weeklytasksAction(Request $request, $unique)
    {
        $datetime = $this->get('datetime');
        $entityManager = $this->get('entity_manager');
        $repositoryUser = $entityManager->getRepository('Application\Sonata\UserBundle\Entity\User');

        if (($user = $repositoryUser->find($unique))) {
            if (($focus = $user->getFocus())) {
                if (($categories = $focus->getCategories())) {
                    $date = $datetime->getDateTime('now');
                    foreach ($categories as $focusCategory) {
                        if (($category = $focusCategory->getCategory())) {
                            if (($weeklytasks = $category->getWeeklytasks())) {
                                foreach ($weeklytasks as $weeklytask) {

                                    $event = new WeeklytaskUserEvent(
                                        (new WeeklytaskUser())
                                            ->setUser($user)
                                            ->setTask($weeklytask)
                                            ->setProcessed(true)
                                            ->setDate($date->modify("+5 minutes"))
                                            ->setProcessedDate($date)
                                    );

                                    $this->get('event_dispatcher')->dispatch(
                                        'fitbase.weeklytask_reminder_create', $event);
                                }
                            }
                        }
                    }
                    $this->get('session')->getFlashBag()->add('success', "Für den Benutzer: {$user->__toString()} wurden alle Infoeinheiten freigegeben.");
                }
            }
        }
        return $this->redirect($request->server->get('HTTP_REFERER'));
    }
}
