<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/23/14
 * Time: 10:54 AM
 */

namespace Fitbase\Bundle\StatisticBundle\Listener;


use Fitbase\Bundle\StatisticBundle\Entity\UserActivity;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserActivitySubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'exercise_done' => array('onExerciseDone', -128),
            'exercise_user_done' => array('onExerciseUserDone', -128),
            'fitbase.exercise_task_done' => array('onExerciseUserTaskDone', -128),
            'feeding_user_create' => array('onFeedingUserCreate', -128),
            'weeklytask_user_done' => array('onWeeklytaskUserDone', -128),
            'weeklyquiz_user_done' => array('onWeeklyquizUserDone', -128),
            'weeklyquiz_user_answer_done' => array('onWeeklyquizUserAnswerDone', -128),
            'gamification_user_emotion_done' => array('onGamificationUserEmotionDone', -128),
            'gamification_dialog_user_answer_done' => array('onGamificationUserAnswerDone', -128),
//            'questionnaire_user_done' => array('onQuestionnaireUserDoneEvent', -128),
        );
    }

    /**
     * Get points count
     * @param $user
     * @return int
     */
    protected function getCountPointTotal($user)
    {
        $managerEntity = $this->container->get('entity_manager');
        $repositoryUserActivity = $managerEntity->getRepository('Fitbase\Bundle\StatisticBundle\Entity\UserActivity');
        if (($activityPrevious = $repositoryUserActivity->findOneLastByUser($user))) {
            return $activityPrevious->getCountPointTotal();
        }
        return 0;
    }

    /**
     * @param Event $event
     */
    public function onFeedingUserCreate(Event $event)
    {
        if (($user = $this->container->get('user')->current())) {

            $activity = new UserActivity();
            $activity->setUser($user);
            $activity->setCountPoint(1);
            $activity->setDate($this->container->get('datetime')->getDateTime('now'));
            $activity->setCountPointTotal($activity->getCountPoint() + $this->getCountPointTotal($user));
            $activity->setText('Eine Ernährungseinheit wurde gespeichert');

            $this->container->get('entity_manager')->persist($activity);
            $this->container->get('entity_manager')->flush($activity);
        }
    }


    /**
     * Store exercise statistic
     * @param Event $event
     */
    public function onExerciseDone(Event $event)
    {
        if (($user = $this->container->get('user')->current())) {

            $activity = new UserActivity();
            $activity->setUser($user);
            $activity->setCountPoint(1);
            $activity->setDate($this->container->get('datetime')->getDateTime('now'));
            $activity->setCountPointTotal($activity->getCountPoint() + $this->getCountPointTotal($user));
            $activity->setText('Eine Übung wurde bearbeitet');

            $this->container->get('entity_manager')->persist($activity);
            $this->container->get('entity_manager')->flush($activity);
        }
    }

    /**
     * @param Event $event
     */
    public function onExerciseUserTaskDone(Event $event)
    {
        if (!($user = $this->container->get('user')->current())) {
            throw new \LogicException('Exercise user task object can not be empty');
        }

        $activity = new UserActivity();
        $activity->setUser($user);
        $activity->setCountPoint(1);
        $activity->setDate($this->container->get('datetime')->getDateTime('now'));
        $activity->setCountPointTotal($activity->getCountPoint() + $this->getCountPointTotal($user));
        $activity->setText('Eine Aufgabe (3 Videos) wurde bearbeitei');

        $this->container->get('entity_manager')->persist($activity);
        $this->container->get('entity_manager')->flush($activity);
    }

    /**
     * Store activity on video done
     * @param Event $event
     */
    public function onExerciseUserDone(Event $event)
    {
        if (!($user = $this->container->get('user')->current())) {
            throw new \LogicException('Exercise user object can not be empty');
        }

        $activity = new UserActivity();
        $activity->setUser($user);
        $activity->setCountPoint(1);
        $activity->setDate($this->container->get('datetime')->getDateTime('now'));
        $activity->setCountPointTotal($activity->getCountPoint() + $this->getCountPointTotal($user));
        $activity->setText('Eine Aufgabe (1 Video) wurde bearbeitei');

        $this->container->get('entity_manager')->persist($activity);
        $this->container->get('entity_manager')->flush($activity);
    }

    /**
     * Store activity for weeklytask
     * @param Event $event
     */
    public function onWeeklytaskUserDone(Event $event)
    {
        assert(($weeklytaskUser = $event->getEntity()));

        $activity = new UserActivity();
        $activity->setUser($weeklytaskUser->getUser());
        $activity->setDate($this->container->get('datetime')->getDateTime('now'));
        $activity->setCountPoint($weeklytaskUser->getTask()->getCountPoint());
        $activity->setCountPointTotal($activity->getCountPoint() + $this->getCountPointTotal($weeklytaskUser->getUser()));
        $activity->setText('Eine Infoeinheit wurde bearbeitet');

        $this->container->get('entity_manager')->persist($activity);
        $this->container->get('entity_manager')->flush($activity);
    }

    /**
     * Store activity for quiz
     * @param Event $event
     */
    public function onWeeklyquizUserDone(Event $event)
    {
        assert(($weeklyquizUser = $event->getEntity()));

        $activity = new UserActivity();
        $activity->setUser($weeklyquizUser->getUser());
        $activity->setDate($this->container->get('datetime')->getDateTime('now'));
        $activity->setCountPoint($weeklyquizUser->getQuiz()->getCountPoint());
        $activity->setCountPointTotal($activity->getCountPoint() + $this->getCountPointTotal($weeklyquizUser->getUser()));
        $activity->setText('Das Quiz wurde beantwortet');

        $this->container->get('entity_manager')->persist($activity);
        $this->container->get('entity_manager')->flush($activity);
    }

    /**
     * Store activity for weeklyquiz user answer
     * @param Event $event
     */
    public function onWeeklyquizUserAnswerDone(Event $event)
    {
        assert(($weeklyquizUserAnswer = $event->getEntity()));

        $activity = new UserActivity();
        $activity->setUser($weeklyquizUserAnswer->getUser());
        $activity->setDate($this->container->get('datetime')->getDateTime('now'));
        $activity->setCountPoint($weeklyquizUserAnswer->getCountPoint());
        $activity->setCountPointTotal($weeklyquizUserAnswer->getCountPoint() + $this->getCountPointTotal($weeklyquizUserAnswer->getUser()));
        $activity->setText('Eine Frage des Quizes wurde beantwortet');

        $this->container->get('entity_manager')->persist($activity);
        $this->container->get('entity_manager')->flush($activity);
    }

    /**
     * Store user emotion activity
     * @param Event $event
     */
    public function onGamificationUserEmotionDone(Event $event)
    {
        assert(($emotion = $event->getEntity()));

        $activity = new UserActivity();
        $activity->setUser($emotion->getUser());
        $activity->setDate($this->container->get('datetime')->getDateTime('now'));
        $activity->setCountPoint(1);
        $activity->setCountPointTotal($activity->getCountPoint() + $this->getCountPointTotal($emotion->getUser()));
        $activity->setText('Eine Emotion wurde gespeichert');

        $this->container->get('entity_manager')->persist($activity);
        $this->container->get('entity_manager')->flush($activity);
    }

    /**
     * Store user activity for last question in health-dialog
     * @param Event $event
     */
    public function onGamificationUserAnswerDone(Event $event)
    {
        assert(($gamificationDialogUserAnswer = $event->getEntity()));

        $activity = new UserActivity();
        $activity->setUser($gamificationDialogUserAnswer->getUser());
        $activity->setDate($this->container->get('datetime')->getDateTime('now'));
        $activity->setCountPoint(1);
        $activity->setCountPointTotal($activity->getCountPoint() + $this->getCountPointTotal($gamificationDialogUserAnswer->getUser()));
        $activity->setText('Das Wohlfühlgespräch wurde durchgeführt');

        $this->container->get('entity_manager')->persist($activity);
        $this->container->get('entity_manager')->flush($activity);
    }

    /**
     * Store user activity from questionnaire
     * @param Event $event
     */
    public function onQuestionnaireUserDoneEvent(Event $event)
    {
        assert(is_object(($questionnaireUser = $event->getEntity())));

        $datetime = $this->container->get('datetime');
        $questionnaire = $this->container->get('questionnaire');

        $activity = new UserActivity();
        $activity->setUser($questionnaireUser->getUser());
        $activity->setDate($this->container->get('datetime')->getDateTime('now'));
        $activity->setCountPoint(
            $questionnaire->getHealthPercent(
                $questionnaireUser->getCountPointHealth()
            )
        );
        $activity->setCountPointTotal($activity->getCountPoint() + $this->getCountPointTotal($questionnaireUser->getUser()));
        $activity->setText('Das Fragebogen wurde bearbeitet und das Gesundheitszustand wurde eingeschätzt');

        $this->container->get('entity_manager')->persist($activity);
        $this->container->get('entity_manager')->flush($activity);


        $activity = new UserActivity();
        $activity->setUser($questionnaireUser->getUser());
        $activity->setDate($this->container->get('datetime')->getDateTime('now'));
        $activity->setCountPoint(
            $questionnaire->getStrainPercent(
                $questionnaireUser->getCountPointStrain()
            )
        );
        $activity->setCountPointTotal($activity->getCountPoint() + $this->getCountPointTotal($questionnaireUser->getUser()));
        $activity->setText('Das Fragebogen wurde bearbeitet und die Belastung wurde eingeschätzt');

        $this->container->get('entity_manager')->persist($activity);
        $this->container->get('entity_manager')->flush($activity);
    }


}