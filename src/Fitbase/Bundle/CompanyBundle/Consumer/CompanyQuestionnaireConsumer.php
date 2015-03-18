<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 12/02/15
 * Time: 14:39
 */
namespace Fitbase\Bundle\CompanyBundle\Consumer;

use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser;
use Fitbase\Bundle\QuestionnaireBundle\Event\QuestionnaireUserEvent;
use Sonata\NotificationBundle\Consumer\ConsumerEvent;
use Sonata\NotificationBundle\Consumer\ConsumerInterface;


class CompanyQuestionnaireConsumer implements ConsumerInterface
{
    protected $datetime;
    protected $serviceUser;
    protected $objectManager;
    protected $eventDispatcher;

    public function __construct($objectManager, $eventDispatcher, $datetime, $serviceUser)
    {
        $this->datetime = $datetime;
        $this->serviceUser = $serviceUser;
        $this->objectManager = $objectManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Process consumer logic,
     * create a QuestionnaireUser Object for all users
     *
     * @param ConsumerEvent $event
     */
    public function process(ConsumerEvent $event)
    {
        if (($message = $event->getMessage())) {
            if (($questionnaireCompany = $message->getValue('questionnaireCompany'))) {
                if (($companyQuestionnaire = $questionnaireCompany->getQuestionnaire())) {
                    if (($company = $questionnaireCompany->getCompany())) {

                        foreach ($company->getUsers() as $user) {
                            if ($this->serviceUser->isGranted($user, 'ROLE_FITBASE_USER')) {

                                $entity = new QuestionnaireUser();
                                $entity->setUser($user);
                                $entity->setDate($questionnaireCompany->getDate());
                                $entity->setSlice($questionnaireCompany);
                                $entity->setQuestionnaire($companyQuestionnaire);
                                $entity->setPause(false);
                                $entity->setDone(false);

                                $event = new QuestionnaireUserEvent($entity);
                                $this->eventDispatcher->dispatch('fitbase.questionnaire_user_create', $event);
                            }
                        }
                    }
                }

                $questionnaireCompany->setProcessed(true);
                $questionnaireCompany->setProcessedDate($this->datetime->getDateTime('now'));

                $this->objectManager->persist($questionnaireCompany);
                $this->objectManager->flush($questionnaireCompany);
            }
        }
    }
}