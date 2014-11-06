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
        $entityManager = $this->get('entity_manager');
        $repositoryCategory = $entityManager->getRepository('Application\Sonata\ClassificationBundle\Entity\Category');
        $repositoryExercise = $entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\Exercise');

        $categories = $repositoryCategory->findAll();
        $exercises = $repositoryExercise->findAll();

        return $this->render('FitbaseExerciseBundle:Exercise:index.html.twig', array(
            'exercises' => $exercises,
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
        $entityManager = $this->get('entity_manager');
        $repositoryCategory = $entityManager->getRepository('Application\Sonata\ClassificationBundle\Entity\Category');
        $repositoryExercise = $entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\Exercise');

        $exercises = null;
        $categories = null;

        if (($category = $repositoryCategory->findOneBySlug($unique))) {
            $exercises = $repositoryExercise->findByCategory($category);
            $categories = $repositoryCategory->findByParent($category);
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
        $entityManager = $this->get('entity_manager');
        $repositoryExercise = $entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\Exercise');

        $exercise = null;

        if (($exercise = $repositoryExercise->findOneById($unique))) {
            $event = new ExerciseEvent($exercise);
            $this->get('event_dispatcher')->dispatch('exercise_user_view', $event);
            $this->get('logger')->debug('[fitbase] exercise view', array($exercise->getId()));
        }

        return $this->render('FitbaseExerciseBundle:Exercise:exercise.html.twig', array(
            'exercise' => $exercise,
        ));
    }
}
