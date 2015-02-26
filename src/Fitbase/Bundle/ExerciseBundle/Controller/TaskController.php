<?php

namespace Fitbase\Bundle\ExerciseBundle\Controller;

use Application\Sonata\UserBundle\Entity\User;
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
        if (($user = $this->get('user')->current())) {

            if (($focus = $user->getFocus())) {
                if (($collection = $focus->getCategories())) {
                    return $this->showTask($user, $collection->map(function ($entity) {
                        return $entity->getCategory();
                    })->toArray());
                }
            }
        }
    }

    /**
     * @param Request $request
     * @param null $slug
     * @param null $unique
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function taskAction(Request $request, $slug = null, $unique = null)
    {
        if (($user = $this->get('user')->current())) {

            $entityManager = $this->get('entity_manager');
            $repositoryCategory = $entityManager->getRepository('Application\Sonata\ClassificationBundle\Entity\Category');

            if (($exercise = $this->get('fitbase.orm.exercise_manager')->findOneById($user, $unique))) {
                return $this->showTask($user, $repositoryCategory->findOneBySlug($slug), $exercise);
            }
        }
    }

    /**
     * Display user task
     *
     * @param $user
     * @param $category
     * @param $exercise
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function showTask(User $user, $category = null, $exercise = null)
    {
        $exercise0 = null;
        $exercise1 = null;
        $exercise2 = null;


        if (($exercises = $this->get('fitbase.orm.exercise_manager')->findThreeRandom($user, $category, $exercise))) {
            $exercise0 = isset($exercises[0]) ? $exercises[0] : null;
            $exercise1 = isset($exercises[1]) ? $exercises[1] : null;
            $exercise2 = isset($exercises[2]) ? $exercises[2] : null;
        }

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

        return $this->render('FitbaseExerciseBundle:Task:task.html.twig', array(
            'user' => $user,
            'step' => !empty($exercise) ? (($exercise->getType() != null) ? ($exercise->getType() - 1) : 0) : (($exercise0->getType() != null) ? ($exercise0->getType() - 1) : 0),
            'exercise' => !empty($exercise) ? $exercise : $exercise0,
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
        if (($user = $this->get('user')->current())) {

            $entityManager = $this->get('entity_manager');
            $repositoryExerciseUser = $entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser');
            if (($exerciseUser = $repositoryExerciseUser->findOneByUserAndId($user, $unique))) {

                $exercise = $exerciseUser->getExercise0();
                $methodNames = array('getExercise0', 'getExercise1', 'getExercise2');
                if (isset($methodNames[$step]) and ($method = $methodNames[$step])) {
                    $exercise = call_user_func_array(array($exerciseUser, $method), array());

                    if ($exercise == $exerciseUser->getExercise2()) {
                        $event = new ExerciseUserEvent($exerciseUser);
                        $this->get('event_dispatcher')->dispatch('exercise_user_done', $event);
                    }
                }

                return $this->render('FitbaseExerciseBundle:Task:user_task.html.twig', array(
                    'step' => $step,
                    'user' => $user,
                    'exercise' => $exercise,
                    'exerciseUser' => $exerciseUser,
                ));
            }
        }
    }
}
