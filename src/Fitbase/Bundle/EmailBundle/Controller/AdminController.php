<?php

namespace Fitbase\Bundle\EmailBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Sonata\AdminBundle\Controller\CoreController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;


class AdminController extends CoreController
{
    /**
     *
     * @param Request $request
     * @param null $unique
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function emailUserRegistrationAction(Request $request, $unique = null)
    {
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {

            $entityManager = $this->get('entity_manager');
            $repositoryUser = $entityManager->getRepository('Application\Sonata\UserBundle\Entity\User');

            $user = $repositoryUser->find($unique);
            return $this->render('FitbaseEmailBundle:Admin:EmailRegistration.html.twig', array(
                'user' => $user,
                'company' => $this->get('company')->current($user),
            ));
        }
    }


    /**
     * Import actioncodes
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function emailWeeklytaskAction(Request $request, $unique = null)
    {
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {

            $entityManager = $this->get('entity_manager');
            $repositoryWeeklytask = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask');

            return $this->render('FitbaseEmailBundle:Admin:EmailWeeklytask.html.twig', array(
                'user' => $this->container->get('user')->current(),
                'company' => $this->container->get('company')->current(),
                'userTask' => new WeeklytaskUser(),
                'task' => $repositoryWeeklytask->find($unique)
            ));
        }
    }

    /**
     * Import actioncodes
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function emailWeeklyquizAction(Request $request, $unique = null)
    {
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {

            $entityManager = $this->get('entity_manager');
            $repositoryWeeklyquiz = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklyquiz');

            return $this->render('FitbaseEmailBundle:Admin:EmailWeeklyquiz.html.twig', array(
                'user' => $this->container->get('user')->current(),
                'company' => $this->container->get('company')->current(),
                'task' => new Weeklytask(),
                'quiz' => $repositoryWeeklyquiz->find($unique),
                'userQuiz' => new WeeklyquizUser(),
            ));
        }
    }


    /**
     * Render exercise email
     * @param Request $request
     * @param null $unique
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function emailExerciseUserReminderAction(Request $request, $unique = null)
    {
        if (!$this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedHttpException('Access denied for non admins');
        }

        $entityManager = $this->get('entity_manager');
        $repository = $entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUserReminder');

        if (!($reminder = $repository->find($unique))) {
            throw new \LogicException('ExerciseUserReminder object not found');
        }

        if (!($user = $reminder->getUser())) {
            throw new \LogicException('ExerciseUserReminder object not found');
        }

        return $this->render('FitbaseEmailBundle:Admin:ExerciseUserReminder/Email.html.twig', array(
            'user' => $user,
            'company' => $user->getCompany(),
            'categoryFocus' => $this->getFocusCategoryMain($user),
            'categories' => $user->getFocus()->getFirstCategories(),
        ));
    }

    /**
     * Get main focus category
     *
     * @param $user
     * @return null
     */
    protected function getFocusCategoryMain($user)
    {
        if (($focus = $user->getFocus())) {
            if (($categoryFocus = $focus->getFirstCategory())) {
                return $categoryFocus->getCategory();
            }
        }
        return NULL;
    }
}
