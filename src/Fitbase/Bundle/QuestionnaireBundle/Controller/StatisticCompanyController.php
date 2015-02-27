<?php

namespace Fitbase\Bundle\QuestionnaireBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class StatisticCompanyController extends Controller
{
    /**
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function questionnaireAction(Request $request, $unique = null)
    {
        $questions = null;

        $entityManager = $this->get('entity_manager');
        $repositoryQuestionnaire = $entityManager->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\Questionnaire');
        if (($questionnaire = $repositoryQuestionnaire->find($unique))) {
            $questions = $questionnaire->getQuestions();
        }

        return $this->render('FitbaseQuestionnaireBundle:Statistic:Company\questionnaire.html.twig', array(
            'questions' => $questions
        ));
    }
}
