<?php

namespace Fitbase\Bundle\ExerciseBundle\Controller;

use Fitbase\Bundle\ExerciseBundle\Component\Chooser\CategoryCompanyChooser;
use Fitbase\Bundle\ExerciseBundle\Component\Chooser\CategoryFocusChooser;
use Fitbase\Bundle\ExerciseBundle\Component\Chooser\ExerciseChooser;
use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseEvent;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ExerciseController extends Controller
{
    /**
     * Show user Exercise
     * @param Request $request
     * @param null $unique
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws AccessDeniedException
     */
    public function exerciseAction(Request $request, $unique = null)
    {
        if (!($user = $this->get('user')->current())) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $entityManager = $this->get('entity_manager');
        $repositoryExercise = $entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\Exercise');

        if (!($exercise = $repositoryExercise->findOneById($unique))) {
            // TODO: notify admin about exercise, that not exists
            $exercise = null;
        }


        return $this->render('FitbaseExerciseBundle:Exercise:exercise.html.twig', array(
            'user' => $user,
            'exercise' => $exercise,
        ));
    }


    public function doneAction(Request $request, $unique = null)
    {
        if (!($user = $this->get('user')->current())) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $entityManager = $this->get('entity_manager');
        $repositoryExercise = $entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\Exercise');

        $event = new ExerciseEvent($repositoryExercise->findOneById($unique));
        $this->get('event_dispatcher')->dispatch('exercise_done', $event);

        return new Response(null, 200);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dialogAction(Request $request)
    {
        return $this->render('FitbaseExerciseBundle:Exercise:dialog.html.twig', array());
    }

}
