<?php

namespace Fitbase\Bundle\UserBundle\Controller;

use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Fitbase\Bundle\UserBundle\Form\ImportForm;
use Fitbase\Bundle\UserBundle\Form\UserImportForm;
use Fitbase\Bundle\UserBundle\Model\DocumentUserImport;
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
                            while (($row = fgetcsv($handle, null, ",", '"')) !== FALSE) {

                                try {

                                    $user = new \Application\Sonata\UserBundle\Entity\User();
                                    $user->setFirstname((isset($row[1]) ? $row[1] : null));
                                    $user->setLastname((isset($row[0]) ? $row[0] : null));
                                    $user->setEmail((isset($row[2]) ? $row[2] : null));
                                    $user->setCompany($document->getCompany());
                                    $user->setUsername($this->get('user')->getUniqueUsername($user));
                                    $user->setPlainPassword($this->get('codegenerator')->password(10));
                                    $user->setExpired(false);
                                    $user->setEnabled(true);

                                    $event = new UserEvent($user);
                                    $this->container->get('event_dispatcher')->dispatch('user_create', $event);


                                    $entityManager->persist($user);
                                    $entityManager->flush($user);

                                    $event = new UserEvent($user);
                                    $this->get('event_dispatcher')->dispatch('user_registered', $event);

                                    continue;

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


        return $this->render('FitbaseUserBundle:Admin:UserImport.html.twig', array(
            'form' => $form->createView(),
            'base_template' => $this->getBaseTemplate(),
            'admin_pool' => $this->container->get('sonata.admin.pool'),
            'blocks' => $this->container->getParameter('sonata.admin.configuration.dashboard_blocks')
        ));
    }
}
