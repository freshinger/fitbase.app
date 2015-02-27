<?php

namespace Fitbase\Bundle\UserBundle\Controller;

use Fitbase\Bundle\UserBundle\Form\UserFocusPriorityForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserWizardController extends Controller
{
    /**
     * Update user focus
     *
     * @param Request $request
     * @return null|\Symfony\Component\HttpFoundation\Response
     */
    public function focusAction(Request $request)
    {
        if (($user = $this->get('user')->current())) {
            if (($focus = $user->getFocus())) {
                if (!$focus->getUpdate()) {

                    $form = $this->createForm(new UserFocusPriorityForm($user), $focus);
                    if ($request->get($form->getName())) {
                        $form->handleRequest($request);
                        if ($form->isValid()) {

                            $entityManager = $this->get('entity_manager');
                            foreach ($focus->getCategories() as $category) {
                                $entityManager->persist($category);
                                $entityManager->flush($category);
                            }

                            $focus->setUpdate(1);
                            $entityManager->persist($focus);
                            $entityManager->flush($focus);

                            $entityManager->refresh($focus);

                            return null;
                        }
                    }

                    return $this->render('FitbaseUserBundle:Subscriber:focus.html.twig', array(
                        'form' => $form->createView(),
                        'user' => $user,
                    ));
                }
            }
        }
    }
}
