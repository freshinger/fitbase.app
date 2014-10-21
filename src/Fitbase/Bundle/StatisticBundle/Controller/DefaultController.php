<?php

namespace Fitbase\Bundle\StatisticBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('FitbaseStatisticBundle:Default:index.html.twig', array('name' => $name));
    }
}
