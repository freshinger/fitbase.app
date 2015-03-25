<?php

namespace Fitbase\Bundle\ReminderBundle\Controller;

use Fitbase\Bundle\ReminderBundle\Form\UserWizardForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserWizardController extends Controller
{
    /**
     * Display wizard action,
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function userWizardAction(Request $request)
    {
        if (($user = $this->get('user')->current())) {
            $entityManager = $this->get('entity_manager');
            $repositoryReminder = $entityManager->getRepository('Fitbase\Bundle\ReminderBundle\Entity\ReminderUser');
            if (($reminder = $repositoryReminder->findOneByUser($user))) {
                if (($reminder->getUpdate())) {

                    $form = $this->createForm(new UserWizardForm(), array());
                    if ($request->get($form->getName())) {
                        $form->handleRequest($request);
                        if ($form->isValid()) {

                            $reminder->setUpdate(false);
                            $entityManager->persist($reminder);
                            $entityManager->flush($reminder);

                            return;
                        }
                    }

                    return $this->render('FitbaseReminderBundle:Wizard:reminder.html.twig', array(
                        'form' => $form->createView()
                    ));
                }
            }
        }
    }
}