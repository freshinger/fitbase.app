<?php

namespace Fitbase\Bundle\EmailBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Sonata\AdminBundle\Controller\CoreController;
use Symfony\Component\HttpFoundation\Request;


class AdminController extends CoreController
{
    /**
     * Import actioncodes
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function emailWeeklytaskAction(Request $request, $unique = null)
    {
        $entityManager = $this->get('entity_manager');
        $repositoryWeeklytask = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask');

        return $this->render('FitbaseEmailBundle:Admin:email_weeklytask.html.twig', array(
            'user' => $this->container->get('user')->current(),
            'userTask' => new WeeklytaskUser(),
            'task' => $repositoryWeeklytask->find($unique)
        ));
    }

    /**
     * Import actioncodes
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function emailWeeklyquizAction(Request $request, $unique = null)
    {
        $entityManager = $this->get('entity_manager');
        $repositoryWeeklyquiz = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklyquiz');

        return $this->render('FitbaseEmailBundle:Admin:email_weeklyquiz.html.twig', array(
            'user' => $this->container->get('user')->current(),
            'task' => new Weeklytask(),
            'quiz' => $repositoryWeeklyquiz->find($unique),
            'userQuiz' => new WeeklyquizUser(),
        ));
    }


    /**
     * Render exercise email
     * @param Request $request
     * @param null $unique
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function emailExerciseUserAction(Request $request, $unique = null)
    {
        $entityManager = $this->get('entity_manager');
        $repositoryExerciseUser = $entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser');

        if (($exerciseUser = $repositoryExerciseUser->find($unique))) {

            $category = null;
            if (($focus = $exerciseUser->getUser()->getFocus())) {
                if (($categoryFocus = $focus->getFirstCategory())) {
                    $categoryFocus = $categoryFocus->getCategory();
                }
            }

            $categories = (new ArrayCollection($this->get('chooser_category')->choose($focus)))
                ->filter(function ($element) {
                    return !$element->getParent() ? true : false;
                });

            return $this->render('FitbaseEmailBundle:Admin:email_exercise.html.twig', array(
                'user' => $exerciseUser->getUser(),
                'categoryFocus' => $categoryFocus,
                'categories' => $categories,
                'exerciseUser' => $exerciseUser,
            ));
        }

    }
}
