<?php

namespace Fitbase\Bundle\UserBundle\Controller;

use Fitbase\Bundle\UserBundle\Entity\UserActioncode;
use Fitbase\Bundle\UserBundle\Event\UserActioncodeEvent;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Fitbase\Bundle\UserBundle\Form\ImportForm;
use Fitbase\Bundle\UserBundle\Form\UserImportForm;
use Fitbase\Bundle\UserBundle\Form\UserInviteForm;
use Fitbase\Bundle\UserBundle\Model\DocumentUserImport;
use Fitbase\Bundle\UserBundle\Model\DocumentUserInvite;
use Sonata\AdminBundle\Controller\CoreController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;


class AdminUserController extends CoreController
{
    public function importAction(Request $request)
    {
        $form = $this->createForm(new UserImportForm(), new DocumentUserImport());

        if ($request->get($form->getName())) {
            $form->handleRequest($request);
            if ($form->isValid()) {


                $entityManager = $this->get('entity_manager');
                $repositoryCompany = $entityManager->getRepository('Fitbase\Bundle\CompanyBundle\Entity\Company');

                if (($document = $form->getData())) {
                    if (($company = $repositoryCompany->find($document->getCompany()))) {

                        if (($handle = fopen($document->getFile()->getRealPath(), "r")) !== FALSE) {
                            while (($row = fgetcsv($handle, null, ";")) !== FALSE) {

                                try {

                                    $email = (isset($row[2]) ? $row[2] : null);
                                    $firstName = (isset($row[0]) ? $row[0] : null);
                                    $lastName = (isset($row[1]) ? $row[1] : null);

                                    $user = new \Application\Sonata\UserBundle\Entity\User();
                                    $user->setEmail($email);
                                    $user->setFirstname($firstName);
                                    $user->setLastname($lastName);
                                    $user->setPlainPassword($this->get('codegenerator')->password(10));
                                    $user->setCompany($document->getCompany());

                                    $this->get('event_dispatcher')->dispatch(
                                        'fitbase.user_register', new UserEvent($user));

                                } catch (\Exception $ex) {
                                    $form->addError(new FormError($ex->getMessage()));
                                }

                            }

                            $this->get('session')->getFlashBag()->add('success', 'Neue Benutzer wurden angelegt.');
                        }
                    }
                }

            }
        }


        return $this->render('FitbaseUserBundle:Admin:User/Import.html.twig', array(
            'form' => $form->createView(),
            'base_template' => $this->getBaseTemplate(),
            'admin_pool' => $this->container->get('sonata.admin.pool'),
            'blocks' => $this->container->getParameter('sonata.admin.configuration.dashboard_blocks')
        ));
    }


    /**
     * Invite user
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function inviteAction(Request $request)
    {
        $form = $this->createForm(new UserInviteForm(), new DocumentUserInvite());

        if ($request->get($form->getName())) {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $entityManager = $this->get('entity_manager');
                $repositoryCompany = $entityManager->getRepository('Fitbase\Bundle\CompanyBundle\Entity\Company');

                if (($document = $form->getData())) {
                    if (($company = $repositoryCompany->find($document->getCompany()))) {

                        if (($handle = fopen($document->getFile()->getRealPath(), "r")) !== FALSE) {
                            while (($row = fgetcsv($handle, null, ";")) !== FALSE) {

                                try {

                                    $entityManager = $this->container->get('entity_manager');
                                    $repositoryUserActioncode = $entityManager->getRepository('Fitbase\Bundle\UserBundle\Entity\UserActioncode');

                                    $actioncode = new UserActioncode();
                                    $actioncode->setPrefix('INV');
                                    $actioncode->setDate($this->container->get('datetime')->getDateTime('now'));
                                    $actioncode->setDuration(NULL);
                                    $actioncode->setCompany($company);
                                    $actioncode->setText($document->getText());
                                    $actioncode->setEmail((isset($row[2]) ? $row[2] : null));
                                    $actioncode->setLastName((isset($row[1]) ? $row[1] : null));
                                    $actioncode->setFirstName((isset($row[0]) ? $row[0] : null));
                                    $actioncode->setCount(0);
                                    $actioncode->setExpire(false);

                                    if (($companyCategories = $company->getCategories())) {
                                        $actioncode->setCategories($companyCategories->map(function ($companyCategory) {
                                            return $companyCategory->getCategory();
                                        })->toArray());
                                    }

                                    do {
                                        $code = $this->container->get('codegenerator')->code(10);
                                        $actioncode->setCode("{$actioncode->getPrefix()}{$code}");
                                    } while ($repositoryUserActioncode->findOneByCode($actioncode->getCode()));

                                    $entityManager->persist($actioncode);
                                    $entityManager->flush($actioncode);

                                    $event = new UserActioncodeEvent($actioncode);
                                    $this->container->get('event_dispatcher')->dispatch('user_actioncode_invite', $event);


                                } catch (\Exception $ex) {
                                    $form->addError(new FormError($ex->getMessage()));
                                }

                            }

                            $this->get('session')->getFlashBag()->add('success', 'Neue Benutzer wurden eingeladen.');
                        }
                    }
                }
            }
        }

        return $this->render('FitbaseUserBundle:Admin:User/Invite.html.twig', array(
            'form' => $form->createView(),
            'base_template' => $this->getBaseTemplate(),
            'admin_pool' => $this->container->get('sonata.admin.pool'),
            'blocks' => $this->container->getParameter('sonata.admin.configuration.dashboard_blocks')
        ));
    }
}
