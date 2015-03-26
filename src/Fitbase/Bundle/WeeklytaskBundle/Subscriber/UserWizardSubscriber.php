<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 10/11/14
 * Time: 13:58
 */

namespace Fitbase\Bundle\WeeklytaskBundle\Subscriber;

use Fitbase\Bundle\FitbaseBundle\Event\UserWizardEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserWizardSubscriber implements EventSubscriberInterface
{
    protected $datetime;
    protected $weeklytask;

    public function __construct($datetime, $weeklytask)
    {
        $this->datetime = $datetime;
        $this->weeklytask = $weeklytask;
    }

    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'user_wizard' => array('onUserWizardEvent', 88),
        );
    }

    /**
     * @param UserWizardEvent $event
     */
    public function onUserWizardEvent(UserWizardEvent $event)
    {


    }
}