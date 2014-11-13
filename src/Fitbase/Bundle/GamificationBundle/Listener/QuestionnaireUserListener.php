<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/11/14
 * Time: 10:27 AM
 */

namespace Fitbase\Bundle\GamificationBundle\Listener;


use Fitbase\Bundle\GamificationBundle\Entity\GamificationUserPointlog;
use Fitbase\Bundle\GamificationBundle\Event\GamificationUserPointlogEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class QuestionnaireUserListener extends ContainerAware
{
    /**
     * Fetch questionnaire user done event and add user points for that
     * @param \Fitbase\Bundle\QuestionnaireBundle\Event\QuestionnaireUserEvent $event
     */
    public function onQuestionnaireUserDoneEvent(\Fitbase\Bundle\QuestionnaireBundle\Event\QuestionnaireUserEvent $event)
    {
        assert(is_object(($questionnaireUser = $event->getEntity())));

        $datetime = $this->container->get('datetime');

        $managerEntity = $this->container->get('entity_manager');
        $repositoryWeeklytaskQuizPlan = $managerEntity->getRepository('Fitbase\Bundle\GamificationBundle\Entity\GamificationUserPointlog');

        $GamificationUserPointlog = new GamificationUserPointlog();
        $GamificationUserPointlog->setUser($questionnaireUser->getUser());
        $GamificationUserPointlog->setDate($datetime->getDateTime('now'));
        $GamificationUserPointlog->setText('Das Fragebogen wurde bearbeitet und das Gesundheitszustand wurde eingeschätzt');
        $GamificationUserPointlog->setCountPoint(
            $this->container->get('questionnaire')->getHealthPercent(
                $questionnaireUser->getCountPointHealth()
            )
        );

        $countPointTotal = $GamificationUserPointlog->getCountPoint();
        if (($GamificationUserPointlogLast = $repositoryWeeklytaskQuizPlan->findOneLastByUser($questionnaireUser->getUser()))) {
            $countPointTotal += $GamificationUserPointlogLast->getCountPointTotal();
        }

        $GamificationUserPointlog->setCountPointTotal($countPointTotal);


        $GamificationUserPointlogEvent = new GamificationUserPointlogEvent($GamificationUserPointlog);
        $this->container->get('event_dispatcher')->dispatch('gamification_pointlog_user_create', $GamificationUserPointlogEvent);

        $GamificationUserPointlog = new GamificationUserPointlog();
        $GamificationUserPointlog->setUser($questionnaireUser->getUser());
        $GamificationUserPointlog->setCountPointTotal(0);
        $GamificationUserPointlog->setDate($datetime->getDateTime('now'));
        $GamificationUserPointlog->setText('Das Fragebogen wurde bearbeitet und die Belastung wurde eingeschätzt');
        $GamificationUserPointlog->setCountPoint(
            $this->container->get('questionnaire')->getStrainPercent(
                $questionnaireUser->getCountPointStrain()
            )
        );

        $countPointTotal = $GamificationUserPointlog->getCountPoint();
        if (($GamificationUserPointlogLast = $repositoryWeeklytaskQuizPlan->findOneLastByUser($questionnaireUser->getUser()))) {
            $countPointTotal += $GamificationUserPointlogLast->getCountPointTotal();
        }

        $GamificationUserPointlog->setCountPointTotal($countPointTotal);

        $GamificationUserPointlogEvent = new GamificationUserPointlogEvent($GamificationUserPointlog);
        $this->container->get('event_dispatcher')->dispatch('gamification_pointlog_user_create', $GamificationUserPointlogEvent);
    }
} 