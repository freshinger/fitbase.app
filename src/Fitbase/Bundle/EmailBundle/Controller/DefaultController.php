<?php

namespace Fitbase\Bundle\EmailBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('FitbaseEmailBundle:Default:index.html.twig', array('name' => $name));
    }
}
