<?php

namespace Fitbase\Bundle\UserBundle\Controller;

use Fitbase\Bundle\UserBundle\Event\UserFocusCategoryEvent;
use Fitbase\Bundle\UserBundle\Event\UserFocusEvent;
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
                // Check is focus
                // have to be updated
                if ($focus->getUpdate()) {

                    $form = $this->createForm(new UserFocusPriorityForm($user), $focus);
                    if ($request->get($form->getName())) {
                        $form->handleRequest($request);
                        if ($form->isValid()) {

                            $event = new UserFocusEvent($focus);
                            $this->get('event_dispatcher')->dispatch('fitbase.user_focus_update', $event);

                            $this->get('entity_manager')->refresh($focus);

                            return null;
                        }
                    }

                    return $this->render('Wizard/FocusSettings.html.twig', array(
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
        $translator = $this->get('translator');
        if (($focus = $this->get('focus')->current())) {
            if (($userFocusCategory = $focus->getFirstCategory())) {
                // Check is category
                // have to be updated
                if ($userFocusCategory->getUpdate()) {
                    // Display this form only for
                    // category ruecken, another categories
                    // have no settings to set up
                    if (($category = $userFocusCategory->getCategory())) {
                        if (in_array($category->getSlug(), array('ruecken'))) {

                            $form = $this->createForm(new UserFocusCategoryForm($userFocusCategory, $translator), $userFocusCategory);
                            if ($request->get($form->getName())) {
                                $form->handleRequest($request);
                                if ($form->isValid()) {

                                    $event = new UserFocusCategoryEvent($userFocusCategory);
                                    $this->get('event_dispatcher')->dispatch('fitbase.user_focus_category_update', $event);

                                    return;
                                }
                            }

                            return $this->render('Wizard/FocusSettingsBack.html.twig', array(
                                'form' => $form->createView(),
                                'focus' => $focus,
                            ));
                        }
                    }
                }
            }
        }
    }
}
