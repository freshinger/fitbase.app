<?php

namespace Fitbase\Bundle\ExerciseBundle\Controller;

use Fitbase\Bundle\ExerciseBundle\Component\Chooser\CategoryCompanyChooser;
use Fitbase\Bundle\ExerciseBundle\Component\Chooser\CategoryFocusChooser;
use Fitbase\Bundle\ExerciseBundle\Component\Chooser\ChooserCompanyCategory;
use Fitbase\Bundle\ExerciseBundle\Component\Chooser\ChooserExercise;
use Fitbase\Bundle\ExerciseBundle\Component\Chooser\ChooserFocusCategory;
use Fitbase\Bundle\ExerciseBundle\Component\Chooser\ExerciseChooser;
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

class FocusController extends Controller
{
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

        if ($this->container->get('focus')->check($user, 'stress')) {
            return $this->stressAction($request);
        }

        if ($this->container->get('focus')->check($user, 'ernaehrung')) {
            return $this->feedingAction($request);
        }

        return $this->rueckenAction($request, $slug);
    }

    /**
     * Display
     * @param Request $request
     * @param null $slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function rueckenAction(Request $request, $slug = null)
    {
        if (!($user = $this->get('user')->current())) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $entityManager = $this->container->get('entity_manager');
        $repositoryCategory = $entityManager->getRepository('Application\Sonata\ClassificationBundle\Entity\Category');

        $exercises = array();
        $categories = array();

        if (($chooserCategory = $this->container->get('chooser_category'))) {
            if (!($categories = $chooserCategory->choose($user->getFocus()))) {
                // TODO: notify admin if no categories exists
            }
        }

        if (($category = $repositoryCategory->findOneBySlug($slug))) {
            if (!($exercises = $category->getExercises())) {
                // TODO: notify admin if no exercises exists
            }
        }


        return $this->render('FitbaseExerciseBundle:Exercise:focus.html.twig', array(
            'exercises' => $exercises,
            'categories' => $categories,
        ));
    }

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

        $resultGroup = array();
        if (($groups = $repositoryFeedingGroup->findAll())) {
            foreach ($groups as $group) {
                $resultGroup[$group->getName()] = $group->getPercent();
            }
        }

        $resultUserItems = array();
        if (($userFeedings = $repositoryFeedingUser->findByUserOrderByDate($user))) {
            foreach ($userFeedings as $key => $userFeeding) {
                if (($date = $userFeeding->getDate())) {
                    $label = $date->format('Y.m.d');

                    $resultUserItems[$label] = array();
                    if (($userItems = $userFeeding->getItems())) {

                        $total = 0;
                        foreach ($userItems as $userItem) {
                            $total += (int)$userItem->getCount();
                            $resultUserItems[$label][$userItem->getGroup()->getName()] = (int)$userItem->getCount();
                        }

                        foreach ($resultUserItems[$label] as $name => $count) {
                            $resultUserItems[$label][$name] = ($count * 100) / $total;
                        }
                    }
                }
            }
        }

        return $this->render('FitbaseExerciseBundle:Exercise:feeding.html.twig', array(
            'form' => $form->createView(),
            'collection' => $repositoryFeedingUser->findByUserOrderByDate($user),
            'groups' => $resultGroup,
            'history' => $resultUserItems,
        ));

    }
}
