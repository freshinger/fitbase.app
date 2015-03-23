<?php

namespace Fitbase\Bundle\UserBundle\Controller;

use Fitbase\Bundle\UserBundle\Event\UserFocusCategoryEvent;
use Fitbase\Bundle\UserBundle\Form\UserFocusCategoryForm;
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

                    return $this->render('FitbaseUserBundle:Wizard:focus.html.twig', array(
                        'form' => $form->createView(),
                        'user' => $user,
                    ));
                }
            }
        }
    }

    /**
     * Get focus settings action
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function focusSettingsAction(Request $request)
    {
        if (($focus = $this->get('focus')->current())) {
            if (($userFocusCategory = $focus->getFirstCategory())) {
                // Display this form only for
                // category ruecken, another categories
                // have no settings to set up
                if (($category = $userFocusCategory->getCategory())) {
                    if (in_array($category->getSlug(), array('ruecken'))) {

                        if (!($userFocusCategory->getPrimary())) {
                            $userFocusCategory->setType(0);
                            $userFocusCategory->setPrimary(
                                $focus->getCategoryBySlug('oberer-rcken')
                            );
                        }

                        $form = $this->createForm(new UserFocusCategoryForm($userFocusCategory), $userFocusCategory);
                        if ($request->get($form->getName())) {
                            $form->handleRequest($request);
                            if ($form->isValid()) {

                                $event = new UserFocusCategoryEvent($userFocusCategory);
                                $this->get('event_dispatcher')->dispatch('fitbase.user_focus_category_update', $event);

                                return;
                            }
                        }

                        return $this->render('FitbaseUserBundle:Wizard:focus_settings.html.twig', array(
                            'form' => $form->createView(),
                            'focus' => $focus,
                        ));
                    }
                }
            }
        }
    }
}
