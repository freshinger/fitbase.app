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
        if (($focus = $this->get('focus')->current())) {
            if (($focusCategory = $focus->getFirstCategory())) {

                $type = $this->getFocusType($focusCategory);
                $category = $this->getFocusCategory($focusCategory);

                switch ($focusCategory->getCategory()->getSlug()) {
                    case 'ruecken':
                        return $this->focusBackAction($request, $category, $type);
                    default:
                        return $this->focusDefaultAction($request, $category, $type);
                }
            }
        }
    }

    /**
     * Get current type from focus
     *
     * @param $focusCategory
     * @return mixed
     */
    protected function getFocusType($focusCategory)
    {
        return $focusCategory->getType();
    }

    /**
     * @param $focusCategory
     * @return mixed
     */
    protected function getFocusCategory($focusCategory)
    {
        if (!($primary = $focusCategory->getPrimary())) {
            return $focusCategory->getCategory();
        }
        return $primary->getCategory();
    }


    /**
     * Display focus action for Ruecken-Category
     * @param Request $request
     * @param $category
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function focusBackAction(Request $request, $category, $type)
    {
        $controller = new TaskController();
        $controller->setContainer($this->container);
        return $controller->focusAction($request, $category->getSlug());
    }

    /**
     * Display focus action for other category
     * @param Request $request
     * @param $category
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function focusDefaultAction(Request $request, $category, $type)
    {
        $controller = new CategoryController();
        $controller->setContainer($this->container);
        return $controller->categoryAction($request, $category->getSlug());
    }

}
