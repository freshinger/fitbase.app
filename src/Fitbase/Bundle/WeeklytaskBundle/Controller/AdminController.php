<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Controller;

use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Form\WeeklyquizUserForm;
use Sonata\AdminBundle\Controller\CoreController;
use Symfony\Component\HttpFoundation\Request;


class AdminController extends CoreController
{
    public function weeklytaskQuizAction(Request $request, $unique)
    {

        $entityManager = $this->get('entity_manager');
        $repositoryWeeklytask = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask');


        if (($weeklytask = $repositoryWeeklytask->find($unique)) and ($weeklyquiz = $weeklytask->getQuiz())) {

            $weeklyquizUser = (new WeeklyquizUser())
                ->setUser($this->get('user')->current())
                ->setQuiz($weeklyquiz);


            $formBuilder = new WeeklyquizUserForm();
            $formBuilder->setContainer($this->container);
            $formBuilder->setWeeklyquizUser($weeklyquizUser);

            $form = $this->createForm($formBuilder, array());


            $notices = array();
            foreach ($weeklyquiz->getQuestions() as $question) {
                foreach ($question->getAnswers() as $answer) {
                    array_push($notices, array(
                        'id' => $answer->getId(),
                        'text' => $answer->getDescription(),
                        'correct' => $answer->getCorrect(),
                    ));
                }
            }


            return $this->render('FitbaseWeeklytaskBundle:Admin:weeklytask_quiz.html.twig', array(
                'form' => $form->createView(),
                'notices' => $notices,
                'weeklyquiz' => $weeklyquizUser,
                'base_template' => $this->getBaseTemplate(),
                'admin_pool' => $this->container->get('sonata.admin.pool'),
                'blocks' => $this->container->getParameter('sonata.admin.configuration.dashboard_blocks')
            ));
        }


    }
}
