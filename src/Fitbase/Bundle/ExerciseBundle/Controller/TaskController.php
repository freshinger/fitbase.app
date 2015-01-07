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
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class TaskController extends Controller
{
    /**
     * Calculate current exercise from focus
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function focusAction(Request $request, $slug = null)
    {
        if (!($user = $this->get('user')->current())) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $entityManager = $this->get('entity_manager');
        $repositoryCategory = $entityManager->getRepository('Application\Sonata\ClassificationBundle\Entity\Category');

        if (!($category = $repositoryCategory->findOneBySlug($slug))) {
            // TODO: notify admin about category, that not exists
            $category = null;
        }

        // Get 3 videos random, but with respect to user focus
        // and create a exercise for user with 3 videos
        $categories = $this->container->get('exercise')->choose($user, $category);
        list($exercise0, $exercise1, $exercise2) = $categories;

        $exerciseUser = new ExerciseUser();
        $exerciseUser->setDone(0);
        $exerciseUser->setUser($user);
        $exerciseUser->setProcessed(1);
        $exerciseUser->setDate($this->get('datetime')->getDateTime('now'));
        $exerciseUser->setExercise0($exercise0);
        $exerciseUser->setExercise1($exercise1);
        $exerciseUser->setExercise2($exercise2);

        $event = new ExerciseUserEvent($exerciseUser);
        $this->get('event_dispatcher')->dispatch('exercise_user_create', $event);

        $event = new ExerciseEvent($exercise0);
        $this->get('event_dispatcher')->dispatch('exercise_done', $event);

        return $this->render('FitbaseExerciseBundle:Task:focus.html.twig', array(
            'step' => 1,
            'user' => $user,
            'exercise' => $exercise0,
            'exerciseUser' => $exerciseUser,
        ));
    }

    /**
     * Show user Exercise
     * @param Request $request
     * @param null $unique
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws AccessDeniedException
     */
    public function taskAction(Request $request, $unique = null)
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

        // Get 3 videos random, but with respect to user focus
        // and create a exercise for user with 3 videos
        $exercises = $this->container->get('exercise')->choose($user, null, $exercise);
        list($exercise0, $exercise1, $exercise2) = $exercises;

        $exerciseUser = new ExerciseUser();
        $exerciseUser->setDone(0);
        $exerciseUser->setUser($user);
        $exerciseUser->setProcessed(1);
        $exerciseUser->setDate($this->get('datetime')->getDateTime('now'));
        $exerciseUser->setExercise0($exercise0);
        $exerciseUser->setExercise1($exercise1);
        $exerciseUser->setExercise2($exercise2);

        $event = new ExerciseUserEvent($exerciseUser);
        $this->get('event_dispatcher')->dispatch('exercise_user_create', $event);

        $event = new ExerciseEvent($exercise0);
        $this->get('event_dispatcher')->dispatch('exercise_done', $event);

        return $this->render('FitbaseExerciseBundle:Task:task.html.twig', array(
            'step' => 1,
            'user' => $user,
            'exercise' => $exercise0,
            'exerciseUser' => $exerciseUser,
        ));
    }

    /**
     * View user exercise
     * @param Request $request
     * @param null $unique
     * @param null $step
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function userTaskAction(Request $request, $unique = null, $step = null)
    {
        if (!($user = $this->get('user')->current())) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $entityManager = $this->get('entity_manager');
        $repositoryExerciseUser = $entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser');
        if (!($exerciseUser = $repositoryExerciseUser->findOneByUserAndId($user, $unique))) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $exercise = $exerciseUser->getExercise0();
        $methodNames = array('getExercise0', 'getExercise1', 'getExercise2');
        if (isset($methodNames[$step]) and ($method = $methodNames[$step])) {
            $exercise = call_user_func_array(array($exerciseUser, $method), array());

            if ($exercise == $exerciseUser->getExercise2()) {
                $event = new ExerciseUserEvent($exerciseUser);
                $this->get('event_dispatcher')->dispatch('exercise_user_done', $event);
            }

            $event = new ExerciseEvent($exercise);
            $this->get('event_dispatcher')->dispatch('exercise_done', $event);
        }

        return $this->render('FitbaseExerciseBundle:Task:user_task.html.twig', array(
            'step' => $step,
            'user' => $user,
            'exercise' => $exercise,
            'exerciseUser' => $exerciseUser,
        ));
    }
}
