<?php

namespace Fitbase\Bundle\UserBundle\Subscriber;


use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseReminderEvent;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserEvent;
use Fitbase\Bundle\QuestionnaireBundle\Event\QuestionnaireUserEvent;
use Fitbase\Bundle\UserBundle\Entity\UserFocus;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Fitbase\Bundle\UserBundle\Event\UserFocusEvent;
use Fitbase\Bundle\UserBundle\Event\UserSingleSignOnEvent;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskReminderEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\AuthenticationEvents;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class QuestionnaireUserSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'questionnaire_user_done' => array('onQuestionnaireUserDoneEvent', -128)
        );
    }

    /**
     * Calculate points for category
     * @param $collection
     * @return float|int
     */
    protected function doCalculateCategoryPosition($collection)
    {
        $result = 0;
        if (count($collection)) {
            foreach ($collection as $userAnswer) {
                if (($question = $userAnswer->getQuestion())) {
                    if (($countPointMax = $question->getCountPointMax()) > 0) {
                        $result += round($userAnswer->getCountPoint() * 100 / $countPointMax);
                    }
                }
            }
        }
        return $result;
    }


    /**
     * Process questionnaire to generate a user focus
     * @param QuestionnaireUserEvent $event
     */
    public function onQuestionnaireUserDoneEvent(QuestionnaireUserEvent $event)
    {
        if (($questionnaireUser = $event->getEntity())) {
            if (($user = $questionnaireUser->getUser())) {
                if (($focus = $user->getFocus())) {
                    if (($userAnswers = $questionnaireUser->getAnswers())) {

                        $categoryPriority = array();
                        foreach ($userAnswers as $userAnswer) {
                            if (($question = $userAnswer->getQuestion())) {
                                if (($categories = $question->getCategories())) {
                                    foreach ($categories as $category) {

                                        if (!isset($categoryPriority[$category->getId()])) {
                                            $categoryPriority[$category->getId()] = array();
                                        }

                                        array_push($categoryPriority[$category->getId()], $userAnswer);
                                    }
                                }
                            }
                        }

                        foreach ($categoryPriority as $id => $row) {
                            $categoryPriority[$id] = $this->doCalculateCategoryPosition($row);
                        }

                        if (arsort($categoryPriority)) {
                            if (($order = array_keys($categoryPriority))) {
                                if (($focusCategories = $focus->getCategories())) {
                                    $entityManager = $this->container->get('entity_manager');

                                    $priorityRest = (count($order) - 1);
                                    foreach ($focusCategories as $focusCategory) {
                                        if (($category = $focusCategory->getCategory())) {

                                            if (($priority = array_search($category->getId(), $order)) !== false) {
                                                $focusCategory->setPriority((int)$priority);
                                            } else {
                                                $focusCategory->setPriority((int)++$priorityRest);
                                            }

                                            $entityManager->persist($focusCategory);
                                            $entityManager->flush($focusCategory);
                                        }
                                    }

                                    $entityManager->refresh($focus);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}