<?php

namespace Fitbase\Bundle\UserBundle\Controller;

use Fitbase\Bundle\UserBundle\Entity\UserPassword;
use Fitbase\Bundle\UserBundle\Entity\UserSearch;
use Fitbase\Bundle\UserBundle\Event\UserPasswordEvent;
use Fitbase\Bundle\UserBundle\Entity\UserProfile;
use Fitbase\Bundle\UserBundle\Event\UserPauseEvent;
use Fitbase\Bundle\UserBundle\Event\UserProfileEvent;
use Fitbase\Bundle\UserBundle\Form\PasswordForm;
use Fitbase\Bundle\UserBundle\Form\UserPauseForm;
use Fitbase\Bundle\UserBundle\Form\UserProfileForm;
use Fitbase\Bundle\UserBundle\Form\UserSearchForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     * Display password form
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function passwordAction()
    {
        $request = $this->get('request');

        $form = $this->createForm(new PasswordForm(), new UserPassword());
        if (!$request->isMethodSafe()) {
            $form->handleRequest($request);
            $form->isValid();
        }

        return $this->render('FitbaseUserBundle:User:password.html.twig', array(
            'form' => $form->createView(),
            'flashbag' => $this->get('session')->getFlashBag(),
        ));
    }

    /**
     * Update user password
     * @return Request
     */
    public function passwordUpdateAction()
    {
        $request = $this->get('request');

        $form = $this->createForm(new PasswordForm(), new UserPassword());
        if (!$request->isMethodSafe()) {
            if ($request->get($form->getName())) {
                $form->handleRequest($request);
                if ($form->isValid()) {

                    $event = new UserPasswordEvent($form->getData());
                    $this->get('event_dispatcher')->dispatch('fitbaseuser_password_update', $event);

                    $this->get('session')->getFlashBag()->add('password', 'Das Password wurde erfolgreich geaendert.');
                }
            }
        }
    }


    /**
     * Display User profile page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function profileAction()
    {
        $request = $this->get('request');

        $user = $this->get('fitbase_manager.user')->getCurrentUser();

        $entity = new UserProfile();
        $entity->setId($user->getId());
        $entity->setEmail($user->getEmail());
        $entity->setAnrede($user->getMetaValue('user_form_of_address'));
        $entity->setTitel($user->getMetaValue('user_title'));
        $entity->setVorname($user->getMetaValue('first_name'));
        $entity->setNachname($user->getMetaValue('last_name'));
        $entity->setStrasse($user->getMetaValue('user_street'));
        $entity->setHausnummer($user->getMetaValue('user_house_number'));
        $entity->setPostzahl($user->getMetaValue('user_zipcode'));
        $entity->setOrt($user->getMetaValue('user_city'));
        $entity->setPhone($user->getMetaValue('user_phone_number'));
        $entity->setHandy($user->getMetaValue('user_cell_phone_number'));
        $entity->setShowInStatistic((boolean)$user->getMetaValue('user_privacy'));

        if (($date = $user->getMetaValue('user_birthday'))) {
            if (($date = unserialize($date))) {
                $entity->setGeburtsdatum($date);
            }
        }

        $form = $this->createForm(new UserProfileForm(), $entity);
        if (!$request->isMethodSafe()) {
            $form->handleRequest($request);
            $form->isValid();
        }

        return $this->render('FitbaseUserBundle:User:profile.html.twig', array(
            'form' => $form->createView(),
            'flashbag' => $this->get('session')->getFlashBag(),
        ));
    }

    /**
     * Save form result
     * @return Response
     */
    public function profileUpdateAction()
    {
        $request = $this->get('request');

        if (($user = $this->get('fitbase_manager.user')->getCurrentUser())) {

            $entity = new UserProfile();
            $entity->setId($user->getId());


            $form = $this->createForm(new UserProfileForm(), $entity);
            if (!$request->isMethodSafe()) {
                if ($request->get($form->getName())) {
                    $form->handleRequest($request);
                    if ($form->isValid()) {

                        $event = new UserProfileEvent($form->getData());
                        $this->get('event_dispatcher')->dispatch('fitbaseuser_profile_update', $event);

                        $this->get('session')->getFlashBag()->add('profile', 'Das Profile wurde erfolgreich geaendert.');
                    }
                }
            }
        }
    }

    /**
     * Enable reminder pause
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function pauseAction(Request $request)
    {
        if (($user = $this->get('fitbase_manager.user')->getCurrentUser())) {

            $repositoryReminder = $this->container->get('fitbase_entity_manager')
                ->getRepository('Fitbase\Bundle\ReminderBundle\Entity\UserReminder');

            if (($reminder = $repositoryReminder->findOneByUser($user))) {

                if ($request->get('user_pause_stop')) {
                    $event = new \Fitbase\Bundle\ReminderBundle\Event\UserReminderEvent($reminder);
                    $this->get('event_dispatcher')->dispatch('reminder_stop_pause', $event);
                    $this->get('session')->getFlashBag()->add('pause', "Die Pause wurde beendet");
                }

                $form = $this->createForm(new UserPauseForm(), $reminder);
                if (!$request->isMethodSafe()) {
                    if ($request->get($form->getName())) {
                        $form->handleRequest($request);
                        if ($form->isValid()) {

                            $event = new UserPauseEvent($form->getData());
                            $this->get('event_dispatcher')->dispatch('reminder_start_pause', $event);

                            $notice = "Die Errinerungfunktion wurde für {$reminder->getPause()} ";
                            if ($reminder->getPause() == 1) {
                                $notice .= " Woche pausiert.";
                            } else {
                                $notice .= " Wochen pausiert.";
                            }

                            $this->get('session')->getFlashBag()->add('pause', $notice);
                        }
                    }
                }

                return $this->render('FitbaseUserBundle:User:pause.html.twig', array(
                    'pause_wochen' => $reminder->getPause(),
                    'pause_start' => $reminder->getPauseStart(),
                    'form' => $form->createView(),
                    'flashbag' => $this->get('session')->getFlashBag(),
                ));
            }
        }
    }

}
