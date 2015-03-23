<?php

namespace Fitbase\Bundle\ExerciseBundle\Controller;

use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\ExerciseBundle\Component\Chooser\CategoryCompanyChooser;
use Fitbase\Bundle\ExerciseBundle\Component\Chooser\CategoryFocusChooser;
use Fitbase\Bundle\ExerciseBundle\Component\Chooser\ExerciseChooser;
use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TaskController extends Controller
{
    /**
     * Calculate current exercise from focus
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function focusAction(Request $request, $slug = null)
    {
        if (($focus = $this->get('focus')->current())) {
            if (($categories = $this->get('focus')->categories())) {
                if (($focusCategoryFirst = $focus->getFirstCategory())) {

                    $exerciseUser = new ExerciseUser();
                    $exerciseUser->setDone(0);
                    $exerciseUser->setUser($focus->getUser());
                    $exerciseUser->setProcessed(1);

                    $datetime = $this->get('datetime');
                    $exerciseUser->setDate($datetime->getDateTime('now'));

                    $exerciseManager = $this->get('fitbase.orm.exercise_manager');
                    $types = $exerciseManager->findTypeByFocusCategoryTypeAndStep($focusCategoryFirst->getType(), 0);
                    $exerciseUser->setExercise0($exerciseManager->findOneByCategoriesAndType($categories, $types));

                    $types = $exerciseManager->findTypeByFocusCategoryTypeAndStep($focusCategoryFirst->getType(), 1);
                    $exerciseUser->setExercise1($exerciseManager->findOneByCategoriesAndType($categories, $types));

                    $types = $exerciseManager->findTypeByFocusCategoryTypeAndStep($focusCategoryFirst->getType(), 2);
                    $exerciseUser->setExercise2($exerciseManager->findOneByCategoriesAndType($categories, $types));

                    $event = new ExerciseUserEvent($exerciseUser);
                    $this->get('event_dispatcher')->dispatch('exercise_user_create', $event);

                    return $this->render('FitbaseExerciseBundle:Task:task.html.twig', array(
                        'step' => 0,
                        'user' => $focus->getUser(),
                        'exercise' => $exerciseUser->getExercise0(),
                        'exerciseUser' => $exerciseUser,
                    ));
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
        if (($focus = $this->get('focus')->current())) {
            if (($categories = $this->get('focus')->categories())) {
                if (($focusCategoryFirst = $focus->getFirstCategory())) {

                    if (($exercise = $this->get('fitbase.orm.exercise_manager')->findOneById($focus->getUser(), $unique))) {

                        $entityManager = $this->get('entity_manager');
                        $repositoryCategory = $entityManager->getRepository('Application\Sonata\ClassificationBundle\Entity\Category');
                        if (($category = $repositoryCategory->findOneBySlug($slug))) {

                            $exerciseUser = new ExerciseUser();
                            $exerciseUser->setDone(0);
                            $exerciseUser->setUser($focus->getUser());
                            $exerciseUser->setProcessed(1);

                            $datetime = $this->get('datetime');
                            $exerciseUser->setDate($datetime->getDateTime('now'));

                            $exerciseUser->setExercise0($exercise);

                            $exerciseManager = $this->get('fitbase.orm.exercise_manager');
                            $types = $exerciseManager->findTypeByFocusCategoryTypeAndStep($focusCategoryFirst->getType(), 1);
                            $exerciseUser->setExercise1($exerciseManager->findOneByCategoriesAndType(array($category), $types));

                            $types = $exerciseManager->findTypeByFocusCategoryTypeAndStep($focusCategoryFirst->getType(), 2);
                            $exerciseUser->setExercise2($exerciseManager->findOneByCategoriesAndType(array($category), $types));

                            $event = new ExerciseUserEvent($exerciseUser);
                            $this->get('event_dispatcher')->dispatch('exercise_user_create', $event);

                            return $this->render('FitbaseExerciseBundle:Task:task.html.twig', array(
                                'step' => 0,
                                'user' => $focus->getUser(),
                                'exercise' => $exerciseUser->getExercise0(),
                                'exerciseUser' => $exerciseUser,
                            ));
                        }
                    }
                }
            }
        }
    }

    /**
     * View user exercise
     *
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
