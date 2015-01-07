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
    public function focusAction(Request $request)
    {
        if (($user = $this->get('user')->current())) {
            if (($focus = $user->getFocus())) {
                if (($categoryFocus = $focus->getCategories()->first())) {

                    if (($category = $categoryFocus->getCategory())) {
                        // Find a parent category
                        // for a given category
                        if (!($parent = $category->getParent())) {
                            $parent = $category;
                        }

                        if (in_array($parent->getSlug(), array('ruecken'))) {
                            $controller = new TaskController();
                            $controller->setContainer($this->container);
                            return $controller->focusAction($request, null);
                        }

                        $controller = new CategoryController();
                        $controller->setContainer($this->container);
                        return $controller->categoryAction($request, $parent->getSlug());
                    }
                }
            }
        }
    }
}
