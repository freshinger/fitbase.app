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
                    return $this->render('FitbaseUserBundle:Registration:registration' . ($internal ? '_internal' : '') . '.html.twig', array(
                        'form' => $form->createView()
                    ));
                }

                return $this->render('FitbaseUserBundle:Registration:code' . ($internal ? '_internal' : '') . '.html.twig', array(
                    'form' => $formActioncode->createView()
                ));
            }

            if ($request->get($formRegistration->getName())) {
                $formRegistration->handleRequest($request);

                if ($formRegistration->isValid()) {

                    $entityManager = $this->get('entity_manager');
                    $repositoryUser = $entityManager->getRepository('Application\Sonata\UserBundle\Entity\User');
                    $repositoryUserActioncode = $entityManager->getRepository('Fitbase\Bundle\UserBundle\Entity\UserActioncode');
                    if (($actioncode = $repositoryUserActioncode->findOneByCode($formRegistration->getData()->getActioncode()))) {

                        $user = new \Application\Sonata\UserBundle\Entity\User();
                        $user->setFirstname($formRegistration->getData()->getFirstName());
                        $user->setLastname($formRegistration->getData()->getLastName());

                        $username = (new Slugify())->slugify("{$user->getFirstname()}_{$user->getLastName()}");
                        while (($collection = $repositoryUser->findByUsername($username))) {
                            $username = $username . count($collection);
                        }

                        $user->setUsername($username);
                        $user->setEmail($formRegistration->getData()->getEmail());
                        $user->setPlainPassword($this->get('codegenerator')->password(10));
                        $user->setCompany($actioncode->getCompany());
                        $user->setEnabled(true);
                        $user->setExpired(false);

                        $event = new UserEvent($user);
                        $this->container->get('event_dispatcher')->dispatch('user_create', $event);

                        $entityManager->persist($user);
                        $entityManager->flush($user);

                        $userFocus = new UserFocus();
                        $userFocus->setUser($user);

                        $entityManager = $this->container->get('entity_manager');
                        $entityManager->persist($userFocus);
                        $entityManager->flush($userFocus);

                        $user->setFocus($userFocus);
                        $user->setActioncode($actioncode);
                        $entityManager->persist($user);
                        $entityManager->flush($user);

                        if (($categories = $actioncode->getCategories())) {
                            foreach ($categories as $category) {
                                $this->doCreateUserFocusCategory($userFocus, $category);
                            }
                        }

                        $actioncode->setUser($user);
                        $actioncode->setProcessed(true);
                        $actioncode->setProcessedDate($this->get('datetime')->getDateTime('now'));

                        $entityManager->persist($actioncode);
                        $entityManager->flush($actioncode);


                        $eventActioncode = new UserActioncodeEvent($actioncode);
                        $this->container->get('event_dispatcher')->dispatch('user_actioncode_processed', $eventActioncode);


                        $event = new UserEvent($user);
                        $this->container->get('event_dispatcher')->dispatch('user_created', $event);


                        $token = new UsernamePasswordToken($user, null, 'admin', $user->getRoles());
                        $this->container->get('security.context')->setToken($token);

                        $this->get('security.context')->setToken(
                            new UsernamePasswordToken($user, null, 'main', $user->getRoles())
                        );

                        return $this->redirect($this->generateUrl('page_slug', array('path' => '/')));
                    }
                }
            }

            return $this->render('FitbaseUserBundle:Registration:registration' . ($internal ? '_internal' : '') . '.html.twig', array(
                'form' => $formRegistration->createView()
            ));
        }

        return $this->render('FitbaseUserBundle:Registration:code' . ($internal ? '_internal' : '') . '.html.twig', array(
            'form' => $formActioncode->createView()
        ));
    }


    /**
     * Create user focus category
     * @param $userFocus
     * @param $category
     */
    protected function doCreateUserFocusCategory($userFocus, $category)
    {
        $focusCategory = new UserFocusCategory();
        $focusCategory->setFocus($userFocus);
        $focusCategory->setCategory($category);
        $focusCategory->setPriority(count($userFocus->getCategories()));

        $this->container->get('entity_manager')->persist($focusCategory);
        $this->container->get('entity_manager')->flush($focusCategory);

        $userFocus->addCategory($focusCategory);

        $this->container->get('entity_manager')->persist($userFocus);
        $this->container->get('entity_manager')->flush($userFocus);
        $this->container->get('entity_manager')->refresh($userFocus);

        if (count(($children = $category->getChildren()))) {
            foreach ($children as $child) {
                $this->doCreateUserFocusCategory($userFocus, $child);
            }
        }
    }


}
