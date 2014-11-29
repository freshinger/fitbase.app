<?php

namespace Fitbase\Bundle\UserBundle\Controller;

use Fitbase\Bundle\UserBundle\Entity\UserImport;
use Fitbase\Bundle\UserBundle\Entity\UserPassword;
use Fitbase\Bundle\UserBundle\Entity\UserSearch;
use Fitbase\Bundle\UserBundle\Entity\Import;

use Fitbase\Bundle\UserBundle\Event\UserImportEvent;
use Fitbase\Bundle\UserBundle\Event\UserPasswordEvent;
use Fitbase\Bundle\UserBundle\Entity\UserProfile;
use Fitbase\Bundle\UserBundle\Event\UserPauseEvent;
use Fitbase\Bundle\UserBundle\Event\UserProfileEvent;
use Fitbase\Bundle\UserBundle\Form\ImportForm;
use Fitbase\Bundle\UserBundle\Form\PasswordForm;
use Fitbase\Bundle\UserBundle\Form\UserPauseForm;
use Fitbase\Bundle\UserBundle\Form\UserProfileForm;
use Fitbase\Bundle\UserBundle\Form\UserSearchForm;
use Fitbase\Bundle\WordpressBundle\Controller\WordpressControllerAbstract;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Exception\LogicException;
use Symfony\Component\Form\FormError;


class AdministrationController extends Controller
{
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


    /**
     * Display admin interface
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function administrationExportAction(Request $request)
    {
        $entity = new UserSearch();
        $entity->setOrder('id');
        $entity->setBy('desc');

        $form = $this->createForm(new UserSearchForm(), $entity, array(
            'action' => '?page=fitbase_user_export'
        ));

        if (!$request->isMethodSafe()) {
            $form->handleRequest($request);
            $form->isValid();
        }

        $queryBuilder = $this->get('entity_manager')
            ->getRepository('Fitbase\Bundle\StatisticBundle\Entity\UserStatistic')
            ->getQueryBuilderUserStatistic($entity);

        $pagerfanta = new Pagerfanta(
            new DoctrineORMAdapter($queryBuilder)
        );
        $pagerfanta->setMaxPerPage(50);
        $pagerfanta->setCurrentPage($request->get('navigate', 1));

        list($fileCsvUrl, $fileExcelUrl) = $this->administrationExportFileAction();

        return $this->render('FitbaseUserBundle:Administration:export.html.twig', array(
            'form' => $form->createView(),
            'pagerfanta' => $pagerfanta,
            'roles' => $this->get('fitbase_wordpress.api')->wpGetOption('ors_user_roles'),
            'flashbag' => $this->get('session')->getFlashBag(),
            'fileCsvUrl' => $fileCsvUrl,
            'fileExcelUrl' => $fileExcelUrl,
        ));
    }

    /**
     * Build files with export
     * @return array
     */
    public function administrationExportFileAction()
    {
        $request = $this->get('request');

        $fileCsvUrl = null;
        $fileExcelUrl = null;
        $fileCsv = 'OrsBenutzerList.csv';
        $fileExcel = 'OrsBenutzerList.xls';

        if (($export = $request->get('export'))) {

            $entity = new UserSearch();
            $entity->setOrder('id');
            $entity->setBy('desc');

            $queryBuilder = $this->get('entity_manager')
                ->getRepository('Fitbase\Bundle\StatisticBundle\Entity\UserStatistic')
                ->getQueryBuilderUserStatistic($entity);

            $pagerfanta = new Pagerfanta(new DoctrineORMAdapter($queryBuilder));
            $pagerfanta->setCurrentPage(1);
            $pagerfanta->setMaxPerPage($pagerfanta->getNbResults());

            // ask the service for a Excel5
            $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

            $phpExcelObject->getProperties()->setCreator("liuggio")
                ->setLastModifiedBy("Giulio De Donato")
                ->setTitle("Office 2005 XLSX Test Document")
                ->setSubject("Office 2005 XLSX Test Document")
                ->setDescription("Test document for Office 2005 XLSX, generated using PHP classes.")
                ->setKeywords("office 2005 openxml php")
                ->setCategory("Test result file");

            $phpExcelObject->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Id')
                ->setCellValue('B1', 'Benutzername')
                ->setCellValue('C1', 'Name')
                ->setCellValue('D1', 'Email')
                ->setCellValue('E1', 'Rolle')
                ->setCellValue('F1', 'Unternehmen')
                ->setCellValue('G1', 'Logins')
                ->setCellValue('H1', 'Videos')
                ->setCellValue('I1', 'Wochanaufgaben')
                ->setCellValue('J1', 'Registriert')
                ->setCellValue('K1', 'Letzter Login')
                ->setCellValue('L1', 'Browser');

            if ($pagerfanta->getNbResults()) {
                foreach ($pagerfanta->getCurrentPageResults() as $id => $statistic) {
                    $phpExcelObject->setActiveSheetIndex(0)
                        ->setCellValue("A" . ($id + 2), $statistic->getUser()->getId())
                        ->setCellValue("B" . ($id + 2), $statistic->getUser()->getNicename())
                        ->setCellValue("C" . ($id + 2), $statistic->getUser()->getDisplayName())
                        ->setCellValue("D" . ($id + 2), $statistic->getUser()->getEmail())
                        ->setCellValue("E" . ($id + 2), $this->get('fitbase_helper.wordpress')->getUserRole($statistic->getUser()))
                        ->setCellValue("F" . ($id + 2), $this->get('fitbase_helper.user')->getCompanyName($statistic->getUser()))
                        ->setCellValue("G" . ($id + 2), $statistic->getCountLogin())
                        ->setCellValue("H" . ($id + 2), $statistic->getCountVideo())
                        ->setCellValue("I" . ($id + 2), implode('/', array(
                            $statistic->getCountWeeklyTaskProcessed(),
                            $statistic->getCountWeeklyTask(),
                        )))
                        ->setCellValue("J" . ($id + 2), $this->get('fitbase_helper.wordpress')->getDate($statistic->getUser()->getRegistered()))
                        ->setCellValue("K" . ($id + 2), $this->get('fitbase_helper.wordpress')->getDate($statistic->getLoggedAt()))
                        ->setCellValue("L" . ($id + 2), $this->get('fitbase_helper.wordpress')->getBrowserFromUserAgent($statistic->getUserAgent()));
                }
            }

            $phpExcelObject->getActiveSheet()->setTitle('Simple');
            $phpExcelObject->setActiveSheetIndex(0);

            if (($uploadDir = $this->get('fitbase_wordpress.api')->wpUploadDir())) {
                switch ($export) {

                    case 'csv':
                        $fileCsvUrl = $uploadDir['url'] . "/$fileCsv";
                        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'CSV');
                        $writer->save($uploadDir['path'] . "/$fileCsv");
                        break;

                    case 'excel':
                        $fileExcelUrl = $uploadDir['url'] . "/$fileExcel";
                        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
                        $writer->save($uploadDir['path'] . "/$fileExcel");
                        break;
                }
            }
        }

        return array($fileCsvUrl, $fileExcelUrl);
    }
}
