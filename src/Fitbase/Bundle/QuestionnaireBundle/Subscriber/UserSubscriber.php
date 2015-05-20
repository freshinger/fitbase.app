<?php

namespace Fitbase\Bundle\QuestionnaireBundle\Subscriber;


use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'fitbase.user_registered' => array('onUserRegisteredEvent'),
        );
    }

    /**
     * Process created user
     * @param UserEvent $event
     */
    public function onUserRegisteredEvent(UserEvent $event)
    {
        $objectManager = $this->container->get('entity_manager');
        if (($user = $event->getEntity())) {

            if (($company = $user->getCompany())) {
                if (($companyQuestionnaire = $company->getQuestionnaire())) {

                    $questionnaireUser = new QuestionnaireUser();
                    $questionnaireUser->setUser($user);
                    $questionnaireUser->setQuestionnaire($companyQuestionnaire);
                    $questionnaireUser->setSlice(null);
                    $questionnaireUser->setDone(false);
                    $questionnaireUser->setPause(false);
                    $questionnaireUser->setCountPoint(0);

                    $objectManager->persist($questionnaireUser);
                    $objectManager->flush($questionnaireUser);
                }
            }

            if (($actioncode = $user->getActioncode())) {
                if (($companyQuestionnaire = $actioncode->getQuestionnaire())) {

                    $questionnaireUser = new QuestionnaireUser();
                    $questionnaireUser->setUser($user);
                    $questionnaireUser->setQuestionnaire($companyQuestionnaire);
                    $questionnaireUser->setDone(false);
                    $questionnaireUser->setPause(false);
                    $questionnaireUser->setCountPoint(0);

                    $objectManager->persist($questionnaireUser);
                    $objectManager->flush($questionnaireUser);
                }
            }
        }
    }
}