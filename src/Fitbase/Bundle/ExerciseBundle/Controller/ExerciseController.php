<?php

namespace Fitbase\Bundle\ExerciseBundle\Controller;

use Fitbase\Bundle\ExerciseBundle\Event\ExerciseEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ExerciseController extends Controller
{
    /**
     * Show categories and exercises
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $exercises = array();
        $categories = array();

        $serviceExercise = $this->get('exercise');
        if (($user = $this->get('user')->current())) {

            $categories = $serviceExercise->categories($user);
            $exercises = $serviceExercise->exercises($user);
        }

        return $this->render('FitbaseExerciseBundle:Exercise:index.html.twig', array(
            'categories' => $categories,
        ));
    }

    /**
     * Display category
     * @param Request $request
     * @param null $unique
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function categoryAction(Request $request, $unique = null)
    {
        $exercises = array();
        $categories = array();

        $serviceExercise = $this->get('exercise');
        if (($user = $this->get('user')->current())) {

            $categories = $serviceExercise->categories($user, $unique);
            $exercises = $serviceExercise->exercises($user, $unique);
        }

        return $this->render('FitbaseExerciseBundle:Exercise:category.html.twig', array(
            'exercises' => $exercises,
            'categories' => $categories,
        ));
    }

    /**
     * Show user Exercise
     * @param Request $request
     * @param null $unique
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(Request $request, $unique = null)
    {
        $exercise = null;

        $serviceExercise = $this->get('exercise');
        if (($user = $this->get('user')->current())) {
            $exercise = $serviceExercise->exercise($user, $unique);
        }

//        $entityManager = $this->get('entity_manager');
//        $repositoryExercise = $entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\Exercise');
//
//        $exercise = null;
//
//        if (($exercise = $repositoryExercise->findOneById($unique))) {
//            $event = new ExerciseEvent($exercise);
//            $this->get('event_dispatcher')->dispatch('exercise_user_done', $event);
//            $this->get('logger')->debug('[fitbase] exercise view', array($exercise->getId()));
//        }

        return $this->render('FitbaseExerciseBundle:Exercise:exercise.html.twig', array(
            'exercise' => $exercise,
        ));
    }
}
