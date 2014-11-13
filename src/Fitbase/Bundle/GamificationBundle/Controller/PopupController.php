<?php

namespace Fitbase\Bundle\GamificationBundle\Controller;

use Fitbase\Bundle\GamificationBundle\Entity\GamificationUser;
use Fitbase\Bundle\GamificationBundle\Event\GamificationUserEvent;
use Fitbase\Bundle\GamificationBundle\Form\GamificationUserForm;
use Fitbase\Bundle\WordpressBundle\Controller\WordpressControllerAbstract;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PopupController extends Controller
{
    /**
     * Display avatar popup if not exists
     * @param Request $request
     * @return Response
     */
    protected function avatarAction(Request $request)
    {
        if (($user = $this->get('user')->current())) {

            $repositoryGamificationUser = $this->get('entity_manager')
                ->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUser');

            if (!($repositoryGamificationUser->findOneByUser($user))) {

                $gamificationUser = new GamificationUser();
                $gamificationUser->setUser($this->get('user')->current());

                $formType = new GamificationUserForm();
                $formType->setContainer($this->container);

                $form = $this->createForm($formType, $gamificationUser);
                if ($request->get($form->getName())) {
                    $form->handleRequest($request);
                    if ($form->isValid()) {

                        $eventGamificationUser = new GamificationUserEvent($gamificationUser);
                        $this->get('event_dispatcher')->dispatch('gamification_user_create', $eventGamificationUser);

                        return $this->redirect('?refresh');
                    }
                }

                return $this->render('FitbaseGamificationBundle:Popup:avatar.html.twig', array(
                    'form' => $form->createView(),
                    'user' => $this->get('user')->current()
                ));
            }
        }

        return new Response('');
    }
}
