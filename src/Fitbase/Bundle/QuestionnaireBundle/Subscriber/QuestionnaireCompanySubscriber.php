<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 10/11/14
 * Time: 13:58
 */

namespace Fitbase\Bundle\QuestionnaireBundle\Subscriber;

use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser;
use Fitbase\Bundle\QuestionnaireBundle\Event\QuestionnaireCompanyEvent;
use Fitbase\Bundle\QuestionnaireBundle\Event\QuestionnaireUserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class QuestionnaireCompanySubscriber implements EventSubscriberInterface
{
    protected $objectManager;

    public function __construct($objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'fitbase.questionnaire_company_remove' => array('onQuestionnaireCompanyRemoveEvent'),
        );
    }

    /**
     * Remove questionnaire comapny object
     * @param QuestionnaireCompanyEvent $event
     */
    public function onQuestionnaireCompanyRemoveEvent(QuestionnaireCompanyEvent $event)
    {
        if (($questionnaireCompany = $event->getEntity())) {

            $this->objectManager->remove($questionnaireCompany);
            $this->objectManager->flush($questionnaireCompany);
        }
    }
}