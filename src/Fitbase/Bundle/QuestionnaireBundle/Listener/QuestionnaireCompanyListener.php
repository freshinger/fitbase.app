<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/1/14
 * Time: 12:49 PM
 */

namespace Fitbase\Bundle\QuestionnaireBundle\Listener;


use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser;
use Fitbase\Bundle\QuestionnaireBundle\Event\QuestionnaireCompanyEvent;
use Fitbase\Bundle\QuestionnaireBundle\Event\QuestionnaireUserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\Event;

class QuestionnaireCompanyListener extends ContainerAware
{
    /**
     * @param QuestionnaireCompanyEvent $event
     */
    public function onQuestionnaireCompanyCreateEvent(QuestionnaireCompanyEvent $event)
    {
        assert(is_object(($questionnaireCompany = $event->getEntity())));


        $this->container->get('entity_manager')->persist($questionnaireCompany);
        $this->container->get('entity_manager')->flush($questionnaireCompany);
    }

    /**
     * @param QuestionnaireCompanyEvent $event
     */
    public function onQuestionnaireCompanyRemoveEvent(QuestionnaireCompanyEvent $event)
    {
        assert(is_object(($questionnaireCompany = $event->getEntity())));

        $this->container->get('entity_manager')->remove($questionnaireCompany);
        $this->container->get('entity_manager')->flush($questionnaireCompany);
    }

    /**
     *
     * @param Event $event
     */
    public function onQuestionnaireCompanyPlanEvent(Event $event)
    {
        assert(is_object(($user = $event->user)));
        assert(is_object(($company = $event->company)));

        $datetime = $this->container->get('datetime');

        $managerEntity = $this->container->get('entity_manager');
        $repositoryQuestionnaireUser = $managerEntity->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser');
        $repositoryQuestionnaireCompany = $managerEntity->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireCompany');

        $collectionQuestionnaireCompany = $repositoryQuestionnaireCompany->findAllByCompanyAndDate($company);
        if (count($collectionQuestionnaireCompany)) {
            $datetimeCurrent = $datetime->getDateTime('now');
            foreach ($collectionQuestionnaireCompany as $questionnaireCompany) {

                $datetimeUser = $user->getRegistered();
                $datetimeUser->modify("+{$questionnaireCompany->getIntervalWeek()} week");

                if ($datetimeCurrent < $datetimeUser) {
                    continue;
                }

                if ($repositoryQuestionnaireUser->findOneByUserAndQuestionnaireCompany($user, $questionnaireCompany)) {
                    continue;
                }

                $questionnaireUser = new QuestionnaireUser();
                $questionnaireUser->setUser($user);
                $questionnaireUser->setQuestionnaireCompany($questionnaireCompany);
                $questionnaireUser->setQuestionnaire($questionnaireCompany->getQuestionnaire());
                $questionnaireUser->setDate($datetimeCurrent);
                $questionnaireUser->setDone(false);

                $eventQuestionnaireUser = new QuestionnaireUserEvent($questionnaireUser);
                $this->container->get('event_dispatcher')->dispatch('questionnaire_user_create', $eventQuestionnaireUser);

            }
        }
    }
} 