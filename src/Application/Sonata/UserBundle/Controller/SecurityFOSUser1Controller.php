<?php
/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Application\Sonata\UserBundle\Controller;

use Fitbase\Bundle\UserBundle\Entity\UserLogin;
use Fitbase\Bundle\UserBundle\Form\UserLoginForm;
use FOS\UserBundle\Controller\SecurityController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class SecurityFOSUser1Controller
 *
 * @package Sonata\UserBundle\Controller
 *
 * @author Hugo Briand <briand@ekino.com>
 */
class SecurityFOSUser1Controller extends SecurityController
{
    /**
     * Create login for fitbase alt and neu
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function loginAction()
    {

        $fitbase = $this->container->get('besimple.soap.client.wellbeing');

        $response = $fitbase->addState('FITSEPPoTZzJdBk', "asdfasdfas", array(
            0,0,0
        ), array(
            0,0,0
        ), array(
            0,0,0
        ), array(
            0,0,0
        ), array(
            0,0,0
        ), array(
            0,0,0
        ), array(
            0,0,0
        ), array(
            0,0,0
        ), array(
            0,0,0
        ), array(
            0,0,0
        ), array(
            0,0,0
        ), array(
            0,0,0
        ), array(
            0,0,0
        ), array(
            0,0,0
        ), array(
            0,0,0
        ), array(
            0,0,0
        ));
        print_r($response);
        exit;


        $form = $this->container->get('form.factory')->create(new UserLoginForm(), new UserLogin());
        if ($this->container->get('request')->get($form->getName())) {
            $form->handleRequest($this->container->get('request'));
            if ($form->isValid()) {

                $linkFitbaseAlt = null;
                $linkFitbaseNeu = null;

                try {

                    $fitbase = $this->container->get('besimple.soap.client.fitbase');
                    $linkFitbaseAlt = $fitbase->login($this->container->getParameter('fitbase.soap_code'),
                        $form->getData()->getLogin(),
                        $form->getData()->getPassword()
                    );

                } catch (\Exception $ex) {
                    $this->container->get('logger')->crit($ex->getMessage());
                }

                $application = $this->container->get('user');
                $linkFitbaseNeu = $application->login(
                    $form->getData()->getLogin(),
                    $form->getData()->getPassword()
                );

                if (strlen($linkFitbaseNeu)) {

                    if (strlen($linkFitbaseAlt)) {
                        return $this->container->get('templating')->renderResponse('ApplicationSonataUserBundle:Login:login_choice.html.twig', array(
                            'linkFitbaseNeu' => $linkFitbaseNeu,
                            'linkFitbaseAlt' => $linkFitbaseAlt,
                        ));
                    }

                    return new RedirectResponse($linkFitbaseNeu);
                }

                if (strlen($linkFitbaseAlt)) {
                    return new RedirectResponse($linkFitbaseAlt);
                }

                $form->addError(new FormError('Benutzername oder Passwort ungültig'));
            }
        }

        return $this->container->get('templating')->renderResponse('ApplicationSonataUserBundle:Login:login.html.twig', array(
            'form' => $form->createView()
        ));
    }
}