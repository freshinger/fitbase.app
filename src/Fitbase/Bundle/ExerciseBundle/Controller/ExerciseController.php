<?php

namespace Fitbase\Bundle\ExerciseBundle\Controller;

use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseEvent;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ExerciseController extends Controller
{
//    /**
//     * Show categories and exercises
//     * @param Request $request
//     * @return \Symfony\Component\HttpFoundation\Response
//     * @throws AccessDeniedException
//     */
//    public function indexAction(Request $request)
//    {
//        if (!($user = $this->get('user')->current())) {
//            throw new AccessDeniedException('This user does not have access to this section.');
//        }
//
//        $serviceExercise = $this->get('exercise');
//        $categories = $serviceExercise->categories($user);
//        $exercises = $serviceExercise->exercises($user, $categories);
//
//        return $this->render('FitbaseExerciseBundle:Exercise:index.html.twig', array(
//            'exercises' => $exercises,
//            'categories' => $categories,
//        ));
//    }

//    /**
//     * Display category
//     * @param Request $request
//     * @param null $unique
//     * @return \Symfony\Component\HttpFoundation\Response
//     * @throws AccessDeniedException
//     */
//    public function categoryAction(Request $request, $unique = null)
//    {
//        if (!($user = $this->get('user')->current())) {
//            throw new AccessDeniedException('This user does not have access to this section.');
//        }
//
//        $serviceExercise = $this->get('exercise');
//        $categories = $serviceExercise->categories($user, $unique);
//        $exercises = $serviceExercise->exercises($user, $unique);
//
//        return $this->render('FitbaseExerciseBundle:Exercise:category.html.twig', array(
//            'exercises' => $exercises,
//            'categories' => $categories,
//        ));
//    }

    /**
     * Redirect to user focus exercise
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function focusAction(Request $request, $slug = null)
    {
        if (!($user = $this->get('user')->current())) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $subcategory = null;
        if ($slug !== null) {
            $entityManager = $this->container->get('entity_manager');
            $repositoryCategory = $entityManager->getRepository('Application\Sonata\ClassificationBundle\Entity\Category');
            $subcategory = $repositoryCategory->findOneBySlug($slug);
        }

        $exercises = $this->get('exercise')->getFocusExercises($user, $subcategory);
        $categories = $this->get('exercise')->getFocusCategories($user, $subcategory);

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

        // Get 3 videos random, but with respect to user focus
        // and create a exercise for user with 3 videos
        $serviceExercise = $this->get('exercise');
        if (($exercise0 = $serviceExercise->exercise($user))) {
            if (($exercise1 = $serviceExercise->exercise($user))) {
                if (($exercise2 = $serviceExercise->exercise($user))) {

                    $entity = new ExerciseUser();
                    $entity->setDone(0);
                    $entity->setUser($user);
                    $entity->setProcessed(1);
                    $entity->setDate($this->get('datetime')->getDateTime('now'));
                    $entity->setExercise0($exercise0);
                    $entity->setExercise1($exercise1);
                    $entity->setExercise2($exercise2);

                    $event = new ExerciseUserEvent($entity);
                    $this->get('event_dispatcher')->dispatch('exercise_user_create', $event);

                    return $this->redirect($this->generateUrl('exercise_user', array(
                        'unique' => $entity->getId(),
                        'step' => 0,
                    )));
                }
            }
        }
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

        // Get selected video as a first video
        // get noch 2 videos random, but with respect to user focus
        // and create a exercise for user with 3 videos
        $serviceExercise = $this->get('exercise');
        if (($exercise0 = $serviceExercise->exercise($user, $unique))) {
            if (($exercise1 = $serviceExercise->exercise($user))) {
                if (($exercise2 = $serviceExercise->exercise($user))) {


                    $entity = new ExerciseUser();
                    $entity->setDone(0);
                    $entity->setUser($user);
                    $entity->setProcessed(1);
                    $entity->setDate($this->get('datetime')->getDateTime('now'));
                    $entity->setExercise0($exercise0);
                    $entity->setExercise1($exercise1);
                    $entity->setExercise2($exercise2);

                    $event = new ExerciseUserEvent($entity);
                    $this->get('event_dispatcher')->dispatch('exercise_user_create', $event);

                    return $this->redirect($this->generateUrl('exercise_user', array(
                        'unique' => $entity->getId(),
                        'step' => 0,
                    )));
                }
            }
        }
    }

    /**
     * View user exercise
     * @param Request $request
     * @param null $unique
     * @param null $step
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewUserAction(Request $request, $unique = null, $step = null)
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
        }

        return $this->render('FitbaseExerciseBundle:Exercise:exercise.html.twig', array(
            'step' => $step,
            'exercise' => $exercise,
            'exerciseUser' => $exerciseUser,
        ));
    }
}
