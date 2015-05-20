<?php

namespace Fitbase\Bundle\UserBundle\Controller;

use Cocur\Slugify\Slugify;
use Fitbase\Bundle\UserBundle\Entity\UserActioncode;
use Fitbase\Bundle\UserBundle\Entity\UserFocus;
use Fitbase\Bundle\UserBundle\Entity\UserFocusCategory;
use Fitbase\Bundle\UserBundle\Entity\UserRegistration;
use Fitbase\Bundle\UserBundle\Event\UserActioncodeEvent;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Fitbase\Bundle\UserBundle\Form\UserActioncodeForm;
use Fitbase\Bundle\UserBundle\Form\UserRegistrationForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class RegistrationController extends Controller
{
    /**
     * Invite user
     * @param Request $request
     * @param null $code
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function inviteAction(Request $request, $code = null)
    {
        $entityManager = $this->get('entity_manager');
        $repositoryUserActioncode = $entityManager->getRepository('Fitbase\Bundle\UserBundle\Entity\UserActioncode');

        if (($actioncode = $repositoryUserActioncode->findOneByCode($code))) {
            return $this->inviteRegistrationAction($request, $actioncode);
        }

        $form = $this->createForm(new UserActioncodeForm(), new UserActioncode(), array(
            'action' => $this->generateUrl('actioncode_invite', array('code' => $code))
        ));

        if ($request->get($form->getName())) {
            $form->handleRequest($request);
            if ($form->isValid()) {

                if (($actioncode = $repositoryUserActioncode->findOneByCode($form->getData()->getCode()))) {
                    return $this->inviteRegistrationAction($request, $actioncode);
                }
            }
        }

        return $this->render('User/UserInvite.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param Request $request
     * @param UserActioncode $actioncode
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function inviteRegistrationAction(Request $request, UserActioncode $actioncode = null)
    {
        $entity = new UserRegistration();
        $entity->setActioncode($actioncode->getCode());
        $entity->setEmail($actioncode->getEmail());
        $entity->setFirstName($actioncode->getFirstName());
        $entity->setLastName($actioncode->getLastName());

        $form = $this->createForm(new UserRegistrationForm(), $entity, array(
            'action' => $this->generateUrl('actioncode_invite', array('code' => $actioncode->getCode()))
        ));

        if ($request->get($form->getName())) {
            $form->handleRequest($request);
            if ($form->isValid()) {

                if (($user = $this->doRegisterUser($entity, $actioncode))) {
                    return $this->redirect(
                        $this->get('fitbase_helper.user')->getSign($user,
                            $this->generateUrl('dashboard', array(), true)
                        )
                    );
                }
            }
        }

        return $this->render('User/UserInviteRegistration.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Update user password
     * @return Request
     */
    public function codeAction(Request $request, $internal = null)
    {
        $formActioncode = $this->createForm(new UserActioncodeForm(), new UserActioncode(), array(
            'action' => $this->generateUrl('actioncode', array('company' => $request->get('company')))
        ));

        $formRegistration = $this->createForm(new UserRegistrationForm(), new UserRegistration(), array(
            'action' => $this->generateUrl('actioncode', array('company' => $request->get('company')))
        ));

        if (!$request->isMethodSafe()) {

            if ($request->get($formActioncode->getName())) {

                $formActioncode->handleRequest($request);
                if ($formActioncode->isValid()) {

                    $entity = new UserRegistration();
                    $entity->setActioncode($formActioncode->getData()->getCode());
                    $form = $this->createForm(new UserRegistrationForm(), $entity);
                    return $this->render('User/Registration' . ($internal ? 'Internal' : '') . '.html.twig', array(
                        'form' => $form->createView()
                    ));
                }

                return $this->render('User/Code' . ($internal ? 'Internal' : '') . '.html.twig', array(
                    'form' => $formActioncode->createView()
                ));
            }

            if ($request->get($formRegistration->getName())) {
                $formRegistration->handleRequest($request);

                if ($formRegistration->isValid()) {

                    $entityManager = $this->get('entity_manager');
                    $repositoryUserActioncode = $entityManager->getRepository('Fitbase\Bundle\UserBundle\Entity\UserActioncode');
                    if (($actioncode = $repositoryUserActioncode->findOneByCode($formRegistration->getData()->getActioncode()))) {

                        if (($user = $this->doRegisterUser($formRegistration->getData(), $actioncode))) {

                            return $this->redirect(
                                $this->get('fitbase_helper.user')->getSign($user,
                                    $this->generateUrl('dashboard', array(), true)
                                )
                            );
                        }


                    }
                }
            }

            return $this->render('User/Registration' . ($internal ? 'Internal' : '') . '.html.twig', array(
                'form' => $formRegistration->createView()
            ));
        }

        return $this->render('User/Code' . ($internal ? 'Internal' : '') . '.html.twig', array(
            'form' => $formActioncode->createView()
        ));
    }

    /**
     * Register user
     * @param UserRegistration $registration
     * @param UserActioncode $actioncode
     * @return \Application\Sonata\UserBundle\Entity\User
     */
    protected function doRegisterUser(UserRegistration $registration, UserActioncode $actioncode)
    {
        $user = new \Application\Sonata\UserBundle\Entity\User();
        $user->setEmail($registration->getEmail());
        $user->setFirstname($registration->getFirstName());
        $user->setLastname($registration->getLastName());
        $user->setPlainPassword($this->get('codegenerator')->password(10));
        $user->setActioncode($actioncode);

        $this->get('event_dispatcher')->dispatch('fitbase.user_register', new UserEvent($user));

        return $user;
    }
}
