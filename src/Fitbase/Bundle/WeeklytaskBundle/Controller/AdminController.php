<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Controller;

use Sonata\AdminBundle\Controller\CoreController;
use Symfony\Component\HttpFoundation\Request;


class AdminController extends CoreController
{

    public function weeklytaskQuizAction(Request $request)
    {
        return $this->render('FitbaseWeeklytaskBundle:Admin:weeklytask_quiz.html.twig', array(

        ));
    }
}
