<?php

namespace Fitbase\Bundle\ExerciseBundle\Controller;

use Fitbase\Bundle\ExerciseBundle\Component\Chooser\CategoryCompanyChooser;
use Fitbase\Bundle\ExerciseBundle\Component\Chooser\CategoryFocusChooser;
use Fitbase\Bundle\ExerciseBundle\Component\Chooser\ExerciseChooser;
use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ExerciseController extends Controller
{
    /**
     * Calculate current exercise from focus
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function exerciseFocusAction(Request $request, $slug = null)
    {
        if (!($user = $this->get('user')->current())) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $entityManager = $this->get('entity_manager');
        $categoryRepository = $entityManager->getRepository('Application\Sonata\ClassificationBundle\Entity\Category');

        if (!($category = $categoryRepository->findOneBySlug($slug))) {
            // TODO: ...
        }

        // Get 3 videos random, but with respect to user focus
        // and create a exercise for user with 3 videos
        list($exercise0, $exercise1, $exercise2) =
            $this->container->get('exercise')->choose($user, $category);

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
            '_sonata_page_skip' => true,
            'unique' => $entity->getId(),
            'step' => 0,
        )));
    }

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
        $categoryRepository = $entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\Exercise');

        list($exercise0, $exercise1, $exercise2) =
            $this->container->get('exercise')->choose($user, null, $categoryRepository->findOneById($unique));

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
            '_sonata_page_skip' => true,
            'unique' => $entity->getId(),
            'step' => 0,
        )));
    }

    /**
     * View user exercise
     * @param Request $request
     * @param null $unique
     * @param null $step
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function exerciseUserAction(Request $request, $unique = null, $step = null)
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

        if (empty($exercise)) {
            // If no exercises defined
            // that means that focus has no activity
            // but theory only, that means
            // we have to break down exercise and show a focus
            $event = new ExerciseUserEvent($exerciseUser);
            $this->get('event_dispatcher')->dispatch('exercise_user_done', $event);
            return $this->redirect($this->generateUrl('focus', array(
                '_sonata_page_skip' => true,
            )));
        }

        return $this->render('FitbaseExerciseBundle:Exercise:exercise.html.twig', array(
            'step' => $step,
            'user' => $user,
            'exercise' => $exercise,
            'exerciseUser' => $exerciseUser,
        ));
    }
}
