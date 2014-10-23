<?php

namespace Fitbase\Bundle\ExerciseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('FitbaseExerciseBundle:Default:index.html.twig', array('name' => $name));
    }
}
