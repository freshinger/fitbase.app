<?php

namespace Fitbase\Bundle\ExerciseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ExerciseController extends Controller
{
    public function indexAction(Request $request)
    {

        $entityManager = $this->get('entity_manager');
        $repositoryCategory = $entityManager->getRepository('Application\Sonata\ClassificationBundle\Entity\Category');
        $repositoryExercise = $entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\Exercise');

        if (($unique = $request->get('unique'))) {
            return $this->exerciseAction($request, $unique);
        }

        $exercises = null;
        $categories = null;

        if (($category = $repositoryCategory->findOneBySlug($request->get('category', 'default')))) {
            $exercises = $repositoryExercise->findByCategory($category);
            $categories = $repositoryCategory->findByParent($category);
        } else {
            $categories = $repositoryCategory->findAll();
        }


        return $this->render('FitbaseExerciseBundle:Exercise:index.html.twig', array(
            'exercises' => $exercises,
            'categories' => $categories,
        ));
    }

    public function exerciseAction(Request $request, $unique = null)
    {
        $entityManager = $this->get('entity_manager');
        $repositoryCategory = $entityManager->getRepository('Application\Sonata\ClassificationBundle\Entity\Category');
        $repositoryExercise = $entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\Exercise');

        if (($exercise = $repositoryExercise->findOneById($unique))) {
            return $this->render('FitbaseExerciseBundle:Exercise:exercise.html.twig', array(
                'exercise' => $exercise,
            ));
        }
    }
}
