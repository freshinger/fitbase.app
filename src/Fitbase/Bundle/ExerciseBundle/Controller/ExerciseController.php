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
        if (($user = $this->get('user')->current())) {
            if (($exercise = $this->get('fitbase.orm.exercise_manager')->findOneById($user, $unique))) {

                return $this->render('Exercise/Exercise.html.twig', array(
                    'user' => $user,
                    'exercise' => $exercise,
                ));
            }
        }
    }

    /**
     * Mark exercise as done
     *
     * @param Request $request
     * @param null $unique
     * @return Response
     */
    public function doneAction(Request $request, $unique = null)
    {
        if (($user = $this->get('user')->current())) {
            if (($exercise = $this->get('fitbase.orm.exercise_manager')->findOneById($user, $unique))) {

                $event = new ExerciseEvent($exercise);
                $this->get('event_dispatcher')->dispatch('exercise_done', $event);

                return new Response(null, 200);
            }
        }
    }

    /**
     *
     * @param Request $request
     * @return Response
     */
    public function exerciseChoiceAction(Request $request)
    {
        $collection = array();
        if (($focus = $this->get('focus')->current())) {
            $collection = $focus->getParentCategories();
        }

        return $this->render('Exercise/ExerciseChoice.html.twig', array(
            'collection' => $collection
        ));
    }
}
