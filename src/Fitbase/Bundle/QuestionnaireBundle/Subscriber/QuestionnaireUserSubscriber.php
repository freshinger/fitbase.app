<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 10/11/14
 * Time: 13:58
 */

namespace Fitbase\Bundle\QuestionnaireBundle\Subscriber;

use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser;
use Fitbase\Bundle\QuestionnaireBundle\Event\QuestionnaireUserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class QuestionnaireUserSubscriber implements EventSubscriberInterface
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
            'fitbase.questionnaire_user_create' => array('onQuestionnaireUserCreateEvent'),
        );
    }

    /**
     * @param QuestionnaireUserEvent $event
     */
    public function onQuestionnaireUserCreateEvent(QuestionnaireUserEvent $event)
    {
        if (($questionnaireUser = $event->getEntity())) {

            $this->objectManager->persist($questionnaireUser);
            $this->objectManager->flush($questionnaireUser);
        }
    }
}