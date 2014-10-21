<?php

namespace Fitbase\Bundle\ReminderBundle\Controller;

use Fitbase\Bundle\ReminderBundle\Entity\ReminderUser;
use Fitbase\Bundle\ReminderBundle\Entity\ReminderUserItem;
use Fitbase\Bundle\ReminderBundle\Entity\ReminderUserPlan;
use Fitbase\Bundle\ReminderBundle\Event\ReminderUserEvent;
use Fitbase\Bundle\ReminderBundle\Event\ReminderUserItemEvent;
use Fitbase\Bundle\ReminderBundle\Event\ReminderUserPlanEvent;
use Fitbase\Bundle\ReminderBundle\Form\ReminderUserForm;
use Fitbase\Bundle\ReminderBundle\Form\ReminderUserItemForm;
use Fitbase\Bundle\WordpressBundle\Controller\WordpressControllerAbstract;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ReminderController extends Controller
{
    /**
     * Setup reminder for user
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function setupAction(Request $request)
    {
        $entityManager = $this->get('fitbase_entity_manager');

        $repositoryReminder = $entityManager->getRepository('Fitbase\Bundle\ReminderBundle\Entity\ReminderUser');
        $repositoryReminderItem = $entityManager->getRepository('Fitbase\Bundle\ReminderBundle\Entity\ReminderUserItem');

        if (($user = $this->get('fitbase_manager.user')->getCurrentUser())) {

            assert(($reminder = $repositoryReminder->findOneByUser($user)));

            if (($id = $request->get('reminder_item_id'))) {
                if (($item = $repositoryReminderItem->findOneByUserAndId($user, $id))) {

                    $event = new ReminderUserItemEvent($item);
                    $this->get('event_dispatcher')->dispatch('reminder_item_remove', $event);

                    $event = new ReminderUserItemEvent($item);
                    $this->get('event_dispatcher')->dispatch('reminder_item_removed', $event);

                    $this->get('session')->getFlashBag()->add('reminder', 'Neues Reminder wurde erfolgreich geloescht.');
                }
            }


            $entity = new ReminderUserItem();
            $entity->setUserId($user->getId());
            $entity->setReminderId($reminder->getId());

            $form = $this->createForm(new ReminderUserItemForm(), $entity);
            if (!$request->isMethodSafe()) {
                $form->handleRequest($request);
                if ($form->isValid()) {

                    $event = new ReminderUserItemEvent($form->getData());
                    $this->get('event_dispatcher')->dispatch('reminder_item_create', $event);

                    $event = new ReminderUserItemEvent($form->getData());
                    $this->get('event_dispatcher')->dispatch('reminder_item_created', $event);

                    $this->get('session')->getFlashBag()->add('reminder', 'Neuer Reminder wurde erfolgreich angelegt.');
                }
            }

            return $this->render('FitbaseReminderBundle:Reminder:setup.html.twig', array(
                'form' => $form->createView(),
                'flashbag' => $this->get('session')->getFlashBag(),
                'items' => $repositoryReminderItem->findAllByReminder($reminder)
            ));
        }
    }

    /**
     * Setup weeklytask sending
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function setupWeeklytaskAction(Request $request)
    {
        $entityManager = $this->get('fitbase_entity_manager');

        $repositoryReminder = $entityManager->getRepository('Fitbase\Bundle\ReminderBundle\Entity\ReminderUser');

        if (($user = $this->get('fitbase_manager.user')->getCurrentUser())) {
            assert(($reminder = $repositoryReminder->findOneByUser($user)));

            $form = $this->createForm(new ReminderUserForm(), $reminder);
            if ($request->get($form->getName())) {
                $form->handleRequest($request);
                if ($form->isValid()) {

                    $event = new ReminderUserEvent($reminder);
                    $this->get('event_dispatcher')->dispatch('reminder_update', $event);

                    $event = new ReminderUserEvent($reminder);
                    $this->get('event_dispatcher')->dispatch('reminder_updated', $event);

                    $this->get('session')->getFlashBag()->add('reminder', 'Die Remindereinstellungen wurden erfolgreich geschpeichert.');
                }
            }

            return $this->render('FitbaseReminderBundle:Reminder:weeklytask.html.twig', array(
                'form' => $form->createView(),
                'flashbag' => $this->get('session')->getFlashBag(),
            ));
        }
    }
}
