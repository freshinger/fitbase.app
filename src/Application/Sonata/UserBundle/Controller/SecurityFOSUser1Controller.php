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

    protected function renderLogin(array $data)
    {
        $template = sprintf('FOSUserBundle:Security:login.html.%s', $this->container->getParameter('fos_user.template.engine'));

        return $this->container->get('templating')->renderResponse($template, array_merge($data, [
            'csrf_token' => false,
        ]));
    }

    /**
     * Create login for fitbase alt and neu
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
//    public function loginAction()
//    {
//        $form = $this->container->get('form.factory')->create(new UserLoginForm(), new UserLogin());
//        if ($this->container->get('request')->get($form->getName())) {
//            $form->handleRequest($this->container->get('request'));
//            if ($form->isValid()) {
//
//                $collection = $this->getRedirectUrl(
//                    $form->getData()->getLogin(),
//                    $form->getData()->getPassword()
//                );
//
//                if (count($collection) > 0) {
//                    if (count($collection) == 2) {
//                        return $this->container->get('templating')
//                            ->renderResponse('User/LoginChoice.html.twig', array(
//                                'linkFitbaseNeu' => $collection[0],
//                                'linkFitbaseAlt' => $collection[1],
//                            ));
//                    }
//
//                    return new RedirectResponse(array_shift($collection));
//                }
//            }
//
//            $form->addError(new FormError('Benutzername oder Passwort ungültig'));
//        }
//
//        return $this->container->get('templating')
//            ->renderResponse('User/Login.html.twig', array(
//                'form' => $form->createView()
//            ));
//    }

//    /**
//     * Get urls to redirect
//     * @param $login
//     * @param $password
//     * @return array
//     */
//    protected function getRedirectUrl($login, $password)
//    {
//        $result = array();
//        if (($urlApp = $this->getRedirectUrlApp($login, $password))) {
//            array_push($result, $urlApp);
//        }
//        if (($urlCoaches = $this->getRedirectUrlCoaches($login, $password))) {
//            array_push($result, $urlCoaches);
//        }
//
//        return $result;
//    }
//
//    /**
//     * Get url to use single sign-on function local
//     * @param $login
//     * @param $password
//     * @return mixed
//     */
//    protected function getRedirectUrlApp($login, $password)
//    {
//        return $this->container->get('user')->login($login, $password);
//    }
//
//    /**
//     * Get single sign-on url for remote fitbase project
//     * @param $login
//     * @param $password
//     * @return null
//     */
//    protected function getRedirectUrlCoaches($login, $password)
//    {
//        try {
//
//            if (($code = $this->container->getParameter('fitbase.soap_code'))) {
//                return $this->container->get('besimple.soap.client.fitbase')
//                    ->login($code, $login, $password);
//            }
//
//            $this->container->get('logger')->crit("[login] Soap code is empty");
//
//        } catch (\Exception $ex) {
//            $this->container->get('logger')->crit("[login] {$ex->getMessage()}");
//        }
//
//        return null;
//    }

}