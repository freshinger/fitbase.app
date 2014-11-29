<?php
namespace Fitbase\Bundle\QuestionnaireBundle\Listener;

use Fitbase\Bundle\QuestionnaireBundle\Entity\Result;
use Fitbase\Bundle\QuestionnaireBundle\Event\ExtraEvent;
use Fitbase\Bundle\QuestionnaireBundle\Event\FocusEvent;
use Fitbase\Bundle\QuestionnaireBundle\Event\PasswordEvent;
use Fitbase\Bundle\QuestionnaireBundle\Event\QuestionnaireUserEvent;
use Fitbase\Bundle\QuestionnaireBundle\Event\SectionEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class QuestionnaireUserListener extends ContainerAware
{
    /**
     * On update questionnaire user event
     * @param QuestionnaireUserEvent $event
     */
    public function onQuestionnaireUserUpdateEvent(QuestionnaireUserEvent $event)
    {
        assert(is_object(($questionnaireUser = $event->getEntity())));

        $this->container->get('entity_manager')->persist($questionnaireUser);
        $this->container->get('entity_manager')->flush($questionnaireUser);
    }

    /**
     * Set questionnaire user as done
     * @param QuestionnaireUserEvent $event
     */
    public function onQuestionnaireUserDoneEvent(QuestionnaireUserEvent $event)
    {
        assert(is_object(($questionnaireUser = $event->getEntity())));

        $questionnaireUser->setDone(true);
        $questionnaireUser->setDoneDate($this->container->get('datetime')->getDateTime('now'));

        $this->container->get('entity_manager')->persist($questionnaireUser);
        $this->container->get('entity_manager')->flush($questionnaireUser);
    }

    /**
     * On create questionnaire user event
     * @param QuestionnaireUserEvent $event
     */
    public function onQuestionnaireUserCreateEvent(QuestionnaireUserEvent $event)
    {
        assert(is_object(($questionnaireUser = $event->getEntity())));


        $this->container->get('entity_manager')->persist($questionnaireUser);
        $this->container->get('entity_manager')->flush($questionnaireUser);
    }

    /**
     * Mark questionnaire as completed
     * @param Event $event
     */
    public function onQuestionnaireDone(Event $event)
    {
        assert(($user = $event->entity), 'User object can not be empty');

        $wordpress = $this->container->get('fitbase_wordpress.api');

        $wordpress->wpUpdateUserMeta($user->getId(), 'user_questionnaire_completed', 1);
    }

    /**
     * Store extra object for current user
     * @param ExtraEvent $event
     */
    public function onQuestionnaireExtra(ExtraEvent $event)
    {
        assert(($extra = $event->getEntity()), 'Extra object can not be empty');

        $user = $this->container->get('user')->current();

        $wordpress = $this->container->get('fitbase_wordpress.api');

        $this->container->get('logger')
            ->info('Questionnaire extra:', array(
                $extra->getAu(),
                $extra->getRs(),
                $extra->getTh()
            ));

        $wordpress->wpUpdateUserMeta($user->getId(), 'user_exercise_eye', $extra->getAu());
        $wordpress->wpUpdateUserMeta($user->getId(), 'user_exercise_rsi', $extra->getRs());
        $wordpress->wpUpdateUserMeta($user->getId(), 'user_exercise_thera', $extra->getTh());
    }

    /**
     * Store focus data for current user
     * @param FocusEvent $event
     */
    public function onQuestionnaireFocus(FocusEvent $event)
    {
        assert(($focus = $event->getEntity()), 'Focus object can not be empty');

        $user = $this->container->get('user')->current();

        $wordpress = $this->container->get('fitbase_wordpress.api');

        $this->container->get('logger')
            ->info('Questionnaire focus:', array(
                $focus->getFocus(),
            ));

        $wordpress->wpUpdateUserMeta($user->getId(), 'user_exercise_focus', $focus->getFocus());
    }

    /**
     * Store section data for current user
     * @param SectionEvent $event
     */
    public function onQuestionnaireSection(SectionEvent $event)
    {
        assert(($data = $event->getData()), 'Section data can not be empty');

        $user = $this->container->get('user')->current();

        $dateTime = $this->container->get('datetime')->getDateTime();

        $resultRepository = $this->container->get('entity_manager')
            ->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\Result');

        if (is_array($data) and count($data)) {
            foreach ($data as $questionId => $answer) {

                $options = array(
                    'userId' => $user->getId(),
                    'questionId' => $questionId,
                );

                if (!($result = $resultRepository->findOneBy($options))) {
                    $result = new Result();
                }

                $result->setUserId($user->getId());
                $result->setQuestionId($questionId);
                $result->setDate($dateTime);

                // TODO: refactoring after statistic
                if (is_array($answer)) {
                    // capability with code from another dev team
                    array_walk($answer, function (&$item, $key) {
                        $item = 'answer_' . $item;
                    });
                    $result->setAnswer(implode(',', $answer));
                } else {
                    // capability with code from another dev team
                    $result->setAnswer('answer_' . $answer);
                }

                $this->container->get('logger')
                    ->info('Questionnaire section:', array(
                        (string)$user,
                        (string)$result,
                    ));

                $this->container->get('entity_manager')->persist($result);
                $this->container->get('entity_manager')->flush($result);
            }
        }
    }

    /**
     * Change user password
     * @param PasswordEvent $event
     */
    public function onQuestionnairePassword(PasswordEvent $event)
    {
        assert(($password = $event->getEntity()), 'Password object can not be empty');

        $user = $this->container->get('user')->current();

        $wordpress = $this->container->get('fitbase_wordpress.api');

        $wordpress->wpSetPassword($password->getPassword(), $user->getId());
        $wordpress->wpSetCurrentUser($user->getId());
        $wordpress->wpSetAuthCookie($user->getId());
    }
}