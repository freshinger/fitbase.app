<?php

namespace Fitbase\Bundle\ExerciseBundle\Controller;

use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser;
use Fitbase\Bundle\ExerciseBundle\Entity\FeedingUser;
use Fitbase\Bundle\ExerciseBundle\Entity\FeedingUserItem;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseEvent;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserEvent;
use Fitbase\Bundle\ExerciseBundle\Event\FeedingUserEvent;
use Fitbase\Bundle\ExerciseBundle\Form\FeedingUserForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ExerciseController extends Controller
{

    /**
     * Display stress page
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function stressAction(Request $request)
    {
        if (!($user = $this->get('user')->current())) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        if (($focus = $user->getFocus())) {
            if (!in_array($focus->getSlug(), array('stress'))) {
                throw new AccessDeniedException('This user does not have access to this section.');
            }
        }


        return $this->render('FitbaseExerciseBundle:Exercise:stress.html.twig', array());
    }

    /**
     * Display feeding page
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function feedingAction(Request $request)
    {
        if (!($user = $this->get('user')->current())) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        if (($focus = $user->getFocus())) {
            if (!in_array($focus->getSlug(), array('ernaehrung'))) {
                throw new AccessDeniedException('This user does not have access to this section.');
            }
        }

        $entity = new FeedingUser();
        $entity->setUser($user);
        $entity->setDate($this->get('datetime')->getDateTime('now'));

        $entityManager = $this->get('entity_manager');
        $repositoryFeedingGroup = $entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\FeedingGroup');
        $repositoryFeedingUser = $entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\FeedingUser');

        if (($collection = $repositoryFeedingGroup->findAll())) {
            foreach ($collection as $feedingGroup) {
                $entity->addItem(
                    (new FeedingUserItem())
                        ->setCount(1)
                        ->setUser($user)
                        ->setGroup($feedingGroup)
                );
            }
        }

        $form = $this->createForm(new FeedingUserForm(), $entity);
        if ($request->get($form->getName())) {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $event = new FeedingUserEvent($entity);
                $this->get('event_dispatcher')->dispatch('feeding_user_create', $event);
            }
        }

        return $this->render('FitbaseExerciseBundle:Exercise:feeding.html.twig', array(
            'form' => $form->createView(),
            'collection' => $repositoryFeedingUser->findByUser($user)
        ));
    }

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

        if (($focus = $user->getFocus())) {
            if (in_array($focus->getSlug(), array('stress', 'ernaerung'))) {
                throw new AccessDeniedException('This user does not have access to this section.');
            }
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
            'user' => $user,
            'exercise' => $exercise,
            'exerciseUser' => $exerciseUser,
        ));
    }
}
