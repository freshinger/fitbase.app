<?php

namespace Fitbase\Bundle\ExerciseBundle\Controller;

use Fitbase\Bundle\ExerciseBundle\Event\ExerciseEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ExerciseController extends Controller
{
    /**
     * Show categories and exercises
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws AccessDeniedException
     */
    public function indexAction(Request $request)
    {
        if (!($user = $this->get('user')->current())) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $serviceExercise = $this->get('exercise');
        $categories = $serviceExercise->categories($user);
        $exercises = $serviceExercise->exercises($user, $categories);

        return $this->render('FitbaseExerciseBundle:Exercise:index.html.twig', array(
            'exercises' => $exercises,
            'categories' => $categories,
        ));
    }

    /**
     * Redirect to user focus exercise
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function focusAction(Request $request)
    {
        if (!($user = $this->get('user')->current())) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $exercises = array();
        $categories = array();

        if (($focus = $user->getFocus())) {
            $categories = $focus->getChildren();
            $exercises = $this->get('exercise')->exercises($user, array($focus));
        }

        return $this->render('FitbaseExerciseBundle:Exercise:focus.html.twig', array(
            'exercises' => $exercises,
            'categories' => $categories,
        ));
    }

    /**
     * Calculate current exercise from focus
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function focusExerciseAction(Request $request)
    {
        if (!($user = $this->get('user')->current())) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        if (($focus = $user->getFocus())) {
            if (($exercises = $focus->getExercises())) {

                $index = rand(0, (count($exercises) - 1));

                if (isset($exercises[$index])) {
                    if (($exercise = $exercises[$index])) {

                        return $this->redirect($this->generateUrl('exercise', array(
                            'unique' => $exercise->getId()
                        )));
                    }
                }
            }
        }
    }

    /**
     * Display category
     * @param Request $request
     * @param null $unique
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws AccessDeniedException
     */
    public function categoryAction(Request $request, $unique = null)
    {
        if (!($user = $this->get('user')->current())) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $serviceExercise = $this->get('exercise');
        $categories = $serviceExercise->categories($user, $unique);
        $exercises = $serviceExercise->exercises($user, $unique);

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
     * @throws AccessDeniedException
     */
    public function viewAction(Request $request, $unique = null)
    {
        if (!($user = $this->get('user')->current())) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $serviceExercise = $this->get('exercise');
        if (($exercise = $serviceExercise->exercise($user, $unique))) {

            $event = new ExerciseEvent($exercise);
            $this->get('event_dispatcher')->dispatch('exercise_user_done', $event);
        }

        return $this->render('FitbaseExerciseBundle:Exercise:exercise.html.twig', array(
            'exercise' => $exercise,
        ));
    }
}
