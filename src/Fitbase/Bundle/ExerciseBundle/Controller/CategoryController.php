<?php

namespace Fitbase\Bundle\ExerciseBundle\Controller;

use Fitbase\Bundle\ExerciseBundle\Component\Chooser\CategoryCompanyChooser;
use Fitbase\Bundle\ExerciseBundle\Component\Chooser\CategoryFocusChooser;
use Fitbase\Bundle\ExerciseBundle\Component\Chooser\ExerciseChooser;
use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser;
use Fitbase\Bundle\ExerciseBundle\Entity\FeedingUser;
use Fitbase\Bundle\ExerciseBundle\Entity\FeedingUserItem;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserEvent;
use Fitbase\Bundle\ExerciseBundle\Event\FeedingUserEvent;
use Fitbase\Bundle\ExerciseBundle\Form\FeedingUserForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CategoryController extends Controller
{
    /**
     * Display parent-category page
     * @param Request $request
     * @param null $slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function categoryAction(Request $request, $slug = null)
    {
        $entityManager = $this->get('entity_manager');
        if (($user = $this->get('user')->current())) {
            if (($focus = $user->getFocus())) {
                $repositoryCategory = $entityManager->getRepository('Application\Sonata\ClassificationBundle\Entity\Category');

                if (($category = $repositoryCategory->findOneBySlug($slug))) {
                    if (($categories = $focus->getCategories())) {

                        // Find a parent category
                        // for a given category
                        if (!($parent = $category->getParent())) {
                            $parent = $category;
                        }

                        // Check is category exists in user focus
                        $exists = $categories->exists(function ($index, $entity) use ($parent) {
                            if ($entity->getCategory()->getSlug() == $parent->getSlug()) {
                                return true;
                            }
                        });

                        if ($exists) {

                            // Exercises only for back
                            // this part have a tasks,
                            // A task have a 3 exercises
                            if (in_array($parent->getSlug(), array('ruecken', 'rueckengesundheit'))) {
                                return $this->categoryBackAction($request, $slug);
                            }

                            if (in_array($parent->getSlug(), array('augen'))) {
                                return $this->categoryAugenAction($request, $slug);
                            }

                            // Stress und all
                            // mental exercises
                            if (in_array($parent->getSlug(), array('stress', 'achtsamkeit', 'resilienz',))) {
                                return $this->categoryStressAction($request, $slug);
                            }
                            // Display feeding-diary and
                            // some exercises like text o image
                            if (in_array($parent->getSlug(), array('ernaehrung'))) {
                                return $this->categoryFeedingAction($request);
                            }

                            return $this->categoryDefaultAction($request, $slug);
                        }
                    }
                }
            }
        }

        return $this->render('FitbaseExerciseBundle:Category:category.html.twig', array());
    }

    /**
     * Display stress page
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function categoryStressAction(Request $request, $slug)
    {
        $user = $this->get('user')->current();
        $entityManager = $this->container->get('entity_manager');
        $repositoryCategory = $entityManager->getRepository('Application\Sonata\ClassificationBundle\Entity\Category');

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

        return $this->render('FitbaseExerciseBundle:Category:category_stress.html.twig', array(
            'exercises' => $exercises,
        ));
    }

    /**
     * Display feeding page
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function categoryFeedingAction(Request $request)
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

        return $this->render('FitbaseExerciseBundle:Category:category_feeding.html.twig', array(
            'form' => $form->createView(),
            'collection' => $repositoryFeedingUser->findByUserOrderByDate($user),
            'groups' => $resultGroup,
            'history' => $resultUserItems,
        ));
    }

    /**
     * Display default category with exercises and other
     * @param Request $request
     * @param null $slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function categoryBackAction(Request $request, $slug = null)
    {
        $user = $this->get('user')->current();
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

        return $this->render('FitbaseExerciseBundle:Category:category_back.html.twig', array(
            'exercises' => $exercises,
            'categories' => $categories,
        ));
    }

    /**
     * Defaul page to display exercises
     * @param Request $request
     * @param null $slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function categoryAugenAction(Request $request, $slug = null)
    {
        $user = $this->get('user')->current();
        $entityManager = $this->container->get('entity_manager');
        $repositoryCategory = $entityManager->getRepository('Application\Sonata\ClassificationBundle\Entity\Category');

        $exercises = array();
        if (($category = $repositoryCategory->findOneBySlug($slug))) {
            $exercises = $category->getExercises();
        }

        return $this->render('FitbaseExerciseBundle:Category:category_augen.html.twig', array(
            'exercises' => $exercises,
        ));
    }

    /**
     * Defaul page to display exercises
     * @param Request $request
     * @param null $slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function categoryDefaultAction(Request $request, $slug = null)
    {
        $user = $this->get('user')->current();
        $entityManager = $this->container->get('entity_manager');
        $repositoryCategory = $entityManager->getRepository('Application\Sonata\ClassificationBundle\Entity\Category');

        $exercises = array();
        if (($category = $repositoryCategory->findOneBySlug($slug))) {
            $exercises = $category->getExercises();
        }

        return $this->render('FitbaseExerciseBundle:Category:category_default.html.twig', array(
            'exercises' => $exercises,
        ));
    }

}
