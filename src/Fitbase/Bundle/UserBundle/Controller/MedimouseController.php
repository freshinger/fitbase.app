<?php

namespace Fitbase\Bundle\UserBundle\Controller;

use Fitbase\Bundle\UserBundle\Builder\BuilderMentee;
use Fitbase\Bundle\UserBundle\Entity\UserMedimouse;
use Fitbase\Bundle\UserBundle\Event\UserMedimouseEvent;
use Fitbase\Bundle\UserBundle\Form\MenteeForm;
use Fitbase\Bundle\UserBundle\Entity\Mentee;
use Fitbase\Bundle\UserBundle\Event\MenteeEvent;
use Fitbase\Bundle\UserBundle\Facade\FacadeUserMentee;
use Fitbase\Bundle\UserBundle\Form\UserMedimouseForm;
use Fitbase\Bundle\WordpressBundle\Controller\WordpressControllerAbstract;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MedimouseController extends WordpressControllerAbstract
{
    public function eingabeAction()
    {
        $entity = new UserMedimouse();

        $form = $this->createForm(new UserMedimouseForm(), $entity);

        if (!$this->get('request')->isMethodSafe()) {
            $form->handleRequest($this->get('request'));
            if ($form->isValid()) {

                $entity->setRegistered(new \DateTime());
                $entity->setLogin($this->container->get('fitbase_manager.user')->generateLogin($entity));
                $entity->setDisplayName($this->container->get('fitbase_manager.user')->generateName($entity));
                $entity->setPassword($this->container->get('fitbase_manager.user')->generatePassword());
                $entity->setRole('teilnehmer');

                $eventUserMedimouse = new UserMedimouseEvent($entity);
                $this->get('event_dispatcher')->dispatch('fitbaseuser_medimouse_create', $eventUserMedimouse);

                $this->get('session')->getFlashBag()->add('notice', 'Ein neuen Benutzer wurde erfolgreich hingefuegt.');

                return $this->redirect($this->generateUrl('therapeut'));
            }
        }

        return $this->render('FitbaseUserBundle:Medimouse:eingabe.html.twig', array(
            'form' => $form->createView(),
            'flashbag' => $this->get('session')->getFlashBag(),
        ));
    }
}
