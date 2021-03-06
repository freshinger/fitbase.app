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
            'fitbase.exercise_user_process' => array('onExerciseUserProcessEvent', -128),
            'fitbase.exercise_user_task_process' => array('onExerciseUserTaskProcessEvent', -128),

            'fitbase.weeklytask_user_done' => array('onWeeklytaskUserDoneEvent', -128),
            'fitbase.weeklyquiz_user_done' => array('onWeeklyquizUserDoneEvent', -128),
            'fitbase.weeklyquiz_user_answer_done' => array('onWeeklyquizUserAnswerDoneEvent', -128),


            'feeding_user_create' => array('onFeedingUserCreate', -128),

            'gamification_user_emotion_done' => array('onGamificationUserEmotionDone', -128),
            'gamification_dialog_user_answer_done' => array('onGamificationUserAnswerDone', -128),
        );
    }


    /**
     * Add user activity point for processed
     * exercise, store exercise too
     *
     * @param Event $event
     */
    public function onExerciseUserProcessEvent(Event $event)
    {
        $datetime = $this->container->get('datetime');
        if (!($exerciseUser = $event->getEntity())) {
            throw new \LogicException('Exercise user object can not be empty');
        }

        if (!($user = $exerciseUser->getUser())) {
            throw new \LogicException('User object can not be empty');
        }

        $activity = (new UserActivity())
            ->setUser($user)
            ->setCountPoint(1)
            ->setExerciseUser($exerciseUser)
            ->setDate($datetime->getDateTime('now'));

        $activity->setCountPointTotal(
            $activity->getCountPoint() +
            $this->getCountPointTotal($user)
        );

        $this->container->get('entity_manager')->persist($activity);
        $this->container->get('entity_manager')->flush($activity);
    }

    /**
     * Add user activity points fro processed task
     * (3 videos), store user task too
     * @param Event $event
     */
    public function onExerciseUserTaskProcessEvent(Event $event)
    {
        $datetime = $this->container->get('datetime');
        if (!($exerciseUserTask = $event->getEntity())) {
            throw new \LogicException('Exercise user task object can not be empty');
        }
        if (!($user = $exerciseUserTask->getUser())) {
            throw new \LogicException('Exercise user task object can not be empty');
        }

        $activity = (new UserActivity())
            ->setUser($user)
            ->setCountPoint(1)
            ->setDate($datetime->getDateTime('now'))
            ->setExerciseUserTask($exerciseUserTask);

        $activity->setCountPointTotal(
            $activity->getCountPoint() +
            $this->getCountPointTotal($user)
        );

        $this->container->get('entity_manager')->persist($activity);
        $this->container->get('entity_manager')->flush($activity);
    }

    /**
     * Add user activity points fro processed weekly task
     *
     * @param Event $event
     */
    public function onWeeklytaskUserDoneEvent(Event $event)
    {
        $datetime = $this->container->get('datetime');
        if (!($weeklytaskUser = $event->getEntity())) {
            throw new \LogicException('Weeklytask user object can not be empty');
        }

        if (!($user = $weeklytaskUser->getUser())) {
            throw new \LogicException('Exercise user task object can not be empty');
        }

        $activity = (new UserActivity())
            ->setUser($user)
            ->setDate($datetime->getDateTime('now'))
            ->setWeeklytaskUser($weeklytaskUser)
            ->setCountPoint($weeklytaskUser->getTask()->getCountPoint());

        $activity->setCountPointTotal(
            $activity->getCountPoint() +
            $this->getCountPointTotal($user)
        );

        $this->container->get('entity_manager')->persist($activity);
        $this->container->get('entity_manager')->flush($activity);
    }

    /**
     * Add user activity points fro processed weekly quiz
     *
     * @param Event $event
     */
    public function onWeeklyquizUserDoneEvent(Event $event)
    {
        $datetime = $this->container->get('datetime');
        if (!($weeklyquizUser = $event->getEntity())) {
            throw new \LogicException('Weeklyquiz user object can not be empty');
        }

        if (!($user = $weeklyquizUser->getUser())) {
            throw new \LogicException('Exercise user task object can not be empty');
        }

        $activity = (new UserActivity())
            ->setUser($user)
            ->setDate($datetime->getDateTime('now'))
            ->setWeeklyquizUser($weeklyquizUser)
            ->setCountPoint($weeklyquizUser->getQuiz()->getCountPoint());

        $activity->setCountPointTotal(
            $activity->getCountPoint() +
            $this->getCountPointTotal($user)
        );

        $this->container->get('entity_manager')->persist($activity);
        $this->container->get('entity_manager')->flush($activity);
    }

    /**
     * Add user activity points fro processed weekly quiz answer
     *
     * @param Event $event
     */
    public function onWeeklyquizUserAnswerDoneEvent(Event $event)
    {
        $datetime = $this->container->get('datetime');
        if (!($weeklyquizUserAnswer = $event->getEntity())) {
            throw new \LogicException('Weeklyquiz user object can not be empty');
        }
        if (!($weeklyquizUser = $weeklyquizUserAnswer->getUserQuiz())) {
            throw new \LogicException('Weeklyquiz user object can not be empty');
        }

        if (!($user = $weeklyquizUser->getUser())) {
            throw new \LogicException('Exercise user task object can not be empty');
        }

        $activity = (new UserActivity())
            ->setUser($user)
            ->setCountPoint(0)
            ->setCountPointTotal($this->getCountPointTotal($user))
            ->setDate($datetime->getDateTime('now'))
            ->setWeeklyquizUser($weeklyquizUser)
            ->setWeeklyquizUserAnswer($weeklyquizUserAnswer);

        $this->container->get('entity_manager')->persist($activity);
        $this->container->get('entity_manager')->flush($activity);
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

}