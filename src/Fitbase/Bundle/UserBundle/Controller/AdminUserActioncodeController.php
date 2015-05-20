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
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Sonata\AdminBundle\Controller\CoreController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Exception\LogicException;
use Symfony\Component\Form\FormError;


class AdminUserActioncodeController extends CoreController
{
    /**
     * Import actioncodes
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function importAction(Request $request)
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
                    foreach (array(" ", "\n\r", "\n",) as $delimeter) {
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
                                    $actioncode->setExpire($entity->getExpire());
                                    $actioncode->setDuration($entity->getDuration());
                                    $actioncode->setDate($this->get('datetime')->getDateTime('now'));
                                    $actioncode->setCategories($entity->getCategories());
                                    $actioncode->setCount(0);

                                    $this->get('entity_manager')->persist($actioncode);

                                    $count++;
                                    continue;
                                }
                                $this->get('session')->getFlashBag()->add('error', "Code: '{$code}' bereites existiert.");
                            }
                        }
                        $this->get('session')->getFlashBag()->add(($count > 0 ? 'success' : 'notice'), "{$count} Actioncode(s) wurde importiert");
                        $this->get('entity_manager')->flush();
                    }
                }
            }
        }

        return $this->render('FitbaseUserBundle:Admin:UserActioncode/Import.html.twig', array(
            'form' => $form->createView(),
            'base_template' => $this->getBaseTemplate(),
            'admin_pool' => $this->container->get('sonata.admin.pool'),
            'blocks' => $this->container->getParameter('sonata.admin.configuration.dashboard_blocks')
        ));
    }
}
