<?php

namespace Fitbase\Bundle\EmailBundle\Controller;

use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Sonata\AdminBundle\Controller\CoreController;
use Symfony\Component\HttpFoundation\Request;


class AdminController extends CoreController
{
    /**
     * Import actioncodes
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function emailWeeklytaskAction(Request $request, $unique = null)
    {
        $entityManager = $this->get('entity_manager');
        $repositoryWeeklytask = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask');

        return $this->render('FitbaseEmailBundle:Admin:email_weeklytask.html.twig', array(
            'user' => $this->container->get('user')->current(),
            'userTask' => new WeeklytaskUser(),
            'task' => $repositoryWeeklytask->find($unique)
        ));
    }
}
