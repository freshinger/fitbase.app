<?php

namespace Fitbase\Bundle\UserBundle\Controller;

use Fitbase\Bundle\UserBundle\Entity\ImportActioncode;
use Fitbase\Bundle\UserBundle\Entity\UserActioncode;
use Fitbase\Bundle\UserBundle\Entity\UserImport;
use Fitbase\Bundle\UserBundle\Entity\UserSearch;
use Fitbase\Bundle\UserBundle\Entity\Import;

use Fitbase\Bundle\UserBundle\Event\UserImportEvent;
use Fitbase\Bundle\UserBundle\Form\ImportActioncodeForm;
use Fitbase\Bundle\UserBundle\Form\ImportForm;
use Fitbase\Bundle\UserBundle\Form\UserSearchForm;
use Sonata\AdminBundle\Controller\CoreController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Exception\LogicException;
use Symfony\Component\Form\FormError;


class AdminController extends CoreController
{

    /**
     * Import actioncodes
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function importCodeAction(Request $request)
    {

        $formModel = new ImportActioncodeForm();
        $formModel->setContainer($this->container);

        $entity = new ImportActioncode();

        $form = $this->createForm($formModel, $entity);
        if ($request->get($form->getName())) {
            $form->handleRequest($request);
            if ($form->isValid()) {

                if (($codes = $entity->getCodes())) {

                    $count = 0;
                    $entityManager = $this->get('entity_manager');
                    $repositoryUserActioncode = $entityManager->getRepository('Fitbase\Bundle\UserBundle\Entity\UserActioncode');

                    $collection = array();
                    foreach (array(" ", "\n") as $delimeter) {
                        if (count(($collection = explode($delimeter, $codes)))) {
                            break;
                        }
                    }

                    if (count($collection)) {
                        foreach ($collection as $code) {
                            if (strlen(($code = trim($code)))) {
                                if (!$repositoryUserActioncode->findOneByCode($code)) {

                                    $actioncode = new UserActioncode();
                                    $actioncode->setCode($code);
                                    $actioncode->setCompany($entity->getCompany());
                                    $actioncode->setQuestionnaire($entity->getQuestionnaire());
                                    $actioncode->setDuration($entity->getDuration());
                                    $actioncode->setDate($this->get('datetime')->getDateTime('now'));
                                    $actioncode->setCategories($entity->getCategories());
                                    $actioncode->setCount(0);

                                    $this->get('entity_manager')->persist($actioncode);

                                    $count++;
                                }
                            }
                        }
                        $this->get('session')->getFlashBag()->add('notice', "{$count} Actioncodes wurde importiert");
                        $this->get('entity_manager')->flush();
                    }
                }
            }
        }

        return $this->render('FitbaseUserBundle:Admin:import_code.html.twig', array(
            'form' => $form->createView(),
            'base_template' => $this->getBaseTemplate(),
            'admin_pool' => $this->container->get('sonata.admin.pool'),
            'blocks' => $this->container->getParameter('sonata.admin.configuration.dashboard_blocks')
        ));
    }


    /**
     * Method to import user records
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function importUser(Request $request)
    {
        return $this->render('FitbaseUserBundle:Admin:import_user.html.twig', array(
            'base_template' => $this->getBaseTemplate(),
            'admin_pool' => $this->container->get('sonata.admin.pool'),
            'blocks' => $this->container->getParameter('sonata.admin.configuration.dashboard_blocks')
        ));
    }


    /**
     * Action to import user from csv file
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function administrationImportAction(Request $request)
    {
        $imported = array();


        $import = new Import();
        $import->setRole('teilnehmer');

        $formType = new ImportForm();
        $formType->setContainer($this->container);

        $form = $this->createForm($formType, $import);
        if ($request->get($form->getName())) {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $datetime = $this->get('datetime');
                $codegenerator = $this->get('codegenerator');
                if (($handle = fopen($import->getFile()->getRealPath(), "r")) !== FALSE) {
                    while (($row = fgetcsv($handle)) !== FALSE) {

                        $userImport = new UserImport();
                        $userImport->setEmail($row[0]);
                        $userImport->setNameFirst($row[1]);
                        $userImport->setNameLast($row[2]);
                        $userImport->setRole($import->getRole());
                        $userImport->setPassword($codegenerator->code(10));
                        $userImport->setText($import->getText());
                        $userImport->setCompany($import->getCompany());
                        $userImport->setRegisteredAt($datetime->getDateTime('now'));
                        $userImport->setAttach1($import->getAttach1());
                        $userImport->setAttach2($import->getAttach2());
                        $userImport->setAttach3($import->getAttach3());
                        $userImport->setLogin($codegenerator->login(
                            $userImport->getNameFirst(),
                            $userImport->getNameLast()
                        ));
                        $userImport->setNameDisplay($codegenerator->name(
                            $userImport->getNameFirst(),
                            $userImport->getNameLast()
                        ));


                        try {

                            $userImportEvent = new UserImportEvent($userImport);
                            $this->get('event_dispatcher')->dispatch('fitbaseuser_import', $userImportEvent);

                            array_push($imported, $userImport);

                        } catch (LogicException $ex) {

                            $form->addError(new FormError("{$ex->getMessage()} Email: {$userImport->getEmail()}"));
                        }
                    }

                    if (($countImported = count($imported))) {
                        $this->get('session')->getFlashBag()->add('notice', "{$countImported} Benutzer wurde erfolgreich angelegt.");
                    }
                }
            }
        }

        return $this->render('FitbaseUserBundle:Administration:import.html.twig', array(
            'form' => $form->createView(),
            'imported' => $imported,
            'flashbag' => $this->get('session')->getFlashBag(),
        ));
    }


}
