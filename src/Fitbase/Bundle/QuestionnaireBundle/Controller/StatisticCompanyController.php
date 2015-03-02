<?php

namespace Fitbase\Bundle\QuestionnaireBundle\Controller;

use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser;
use Fitbase\Bundle\QuestionnaireBundle\Form\QuestionnaireUserForm;
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
        $repositoryQuestionnaire = $entityManager->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireCompany');
        if (($questionnaireCompany = $repositoryQuestionnaire->find($unique))) {

            $entity = new QuestionnaireUser();
            $entity->setUser($this->get('user')->current());
            $entity->setQuestionnaire($questionnaireCompany->getQuestionnaire());

            $form = $this->createForm(new QuestionnaireUserForm($this->container, $entity, 9999), array());

            return $this->render('FitbaseQuestionnaireBundle:Statistic:Company\questionnaire.html.twig', array(
                'form' => $form->createView(),
                'questionnaire' => $questionnaireCompany,
            ));

        }

    }
}
