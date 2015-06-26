<?php

namespace Fitbase\Bundle\UserBundle\Controller;

use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser;
use Fitbase\Bundle\QuestionnaireBundle\Form\Constraint\QuestionnaireQuestionConstraint;
use Fitbase\Bundle\QuestionnaireBundle\Form\QuestionnaireUserForm;
use Fitbase\Bundle\UserBundle\Event\UserFocusCategoryEvent;
use Fitbase\Bundle\UserBundle\Model\UserFocusCategoryQuestionnaireResults;
use Sonata\AdminBundle\Controller\CoreController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;


class UserFocusCategoryController extends CoreController
{
    /**
     * Display and process category questionnaire form
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function questionnaireAction(Request $request, $unique = null)
    {
        $entityManager = $this->get('entity_manager');
        $repository = $entityManager->getRepository('Fitbase\Bundle\CompanyBundle\Entity\CompanyQuestionnaire');

        if (!($user = $this->get('user')->current())) {
            throw new \LogicException('User object not found');
        }

        if (!($questionnaire = $repository->findOneById($unique))) {
            throw new \LogicException('Questionnaire object not found');
        }

        $questionnaireUser =
            (new QuestionnaireUser())
                ->setUser($user)
                ->setQuestionnaire($questionnaire);


        $formBuilder = new QuestionnaireUserForm($this->container, $questionnaireUser, null);
        $form = $this->createForm($formBuilder, []);
        if ($request->get($form->getName())) {
            $form->handleRequest($request);

            // Validate each child
            // form has no defined structure
            foreach ($form as $child) {
                if (($errors = $this->validate($child))) {
                    foreach ($errors as $error) {
                        $child->addError(new FormError($error->getMessage()));
                    }
                }
            }

            if ($form->isValid()) {

                if (!($result = $this->process($questionnaireUser, $form->getData()))) {
                    throw new \LogicException('Can not process answers');
                }

                if (!($userFocus = $this->get('focus')->current())) {
                    throw new \LogicException('Focus object can not be empty');
                }

                if (!($categories = $result->getWinnerCategories())) {
                    throw new \LogicException('Categories list can not be empty');
                }

                if (!isset($categories[0]) or !($categoryFirst = $categories[0])) {
                    throw new \LogicException('Focus object can not be empty');
                }

                if (!($parent = $categoryFirst->getParent())) {
                    throw new \LogicException('Subcategories should have a parents');
                }

                if (!($userFocusCategory = $userFocus->getCategoryBySlug($parent->getSlug()))) {
                    throw new \LogicException('Focus category object can not be empty');
                }

                foreach ($categories as $category) {
                    $focusCategory = $userFocus->getCategoryBySlug($category->getSlug());
                    $userFocusCategory->addPrimary($focusCategory);
                }

                $event = new UserFocusCategoryEvent($userFocusCategory);
                $this->get('event_dispatcher')->dispatch('fitbase.user_focus_category_update', $event);

                return $this->render('User/Focus/CategoryQuestionnaireResults.html.twig', [
                    'categories' => $categories,
                    'description' => (string)$result,
                    'questionnaire' => $questionnaire,
                ]);
            }
        }


        return $this->render('User/Focus/CategoryQuestionnaire.html.twig', [
            'form' => $form->createView(),
            'questionnaire' => $questionnaire,
        ]);
    }

    /**
     * Process answers and get result
     *
     * @param $questionnaireUser
     * @param $answers
     * @return null
     */
    protected function process($questionnaireUser, $answers = [])
    {
        $entityManager = $this->get('entity_manager');
        $repositoryQuestionnaireQuestion = $entityManager->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireQuestion');

        $result = new UserFocusCategoryQuestionnaireResults();
        foreach ($answers as $questionId => $answerId) {
            if (($questionnaireQuestion = $repositoryQuestionnaireQuestion->find($questionId))) {
                if ((list($points, $answers, $text) = $this->points($answerId))) {
                    if (($categories = $questionnaireQuestion->getCategories())) {
                        foreach ($categories as $category) {
                            $result->addResult($points, $category);
                        }
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Process questionnaire answers
     * @param $array
     * @return array|null
     */
    protected function points($array)
    {
        $points = 0;

        if (is_numeric($array) or is_array($array)) {

            if (!is_array($array)) {
                $array = [$array];
            }

            $managerEntity = $this->get('entity_manager');
            $repositoryQuestionnaireAnswer = $managerEntity->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireAnswer');

            if (count(($answers = $repositoryQuestionnaireAnswer->findAllById($array)))) {
                foreach ($answers as $answer) {
                    $points += $answer->getCountPoint();
                }
                return [$points, $answers, null];
            }
        }

        return [0, [], array_shift($array)];
    }

    /**
     * Validate questionnaire question
     * @param $form
     * @return mixed
     */
    protected function validate($form)
    {
        return $this->get('validator')->validateValue($form->getData(),
            new QuestionnaireQuestionConstraint());
    }

}
