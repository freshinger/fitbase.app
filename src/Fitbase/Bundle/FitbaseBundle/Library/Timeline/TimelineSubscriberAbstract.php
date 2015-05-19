<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 18/05/15
 * Time: 15:29
 */

namespace Fitbase\Bundle\FitbaseBundle\Library\Timeline;


use Spy\Timeline\Model\ComponentInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TimelineSubscriberAbstract implements EventSubscriberInterface
{
    protected $userManager;
    protected $actionManager;

    public function __construct($userManager, $actionManager)
    {
        $this->userManager = $userManager;
        $this->actionManager = $actionManager;
    }

    /**
     * Subscribe to events
     */
    public static function getSubscribedEvents()
    {
        throw new \LogicException('No events subscribed');
    }

    /**
     * @return ComponentInterface
     */
    protected function getSubject()
    {
        return $this->actionManager->findOrCreateComponent(
            $this->userManager->current()
        );
    }

    /**
     * @return ComponentInterface
     */
    protected function getTarget($object = null)
    {
        return $this->actionManager->findOrCreateComponent($object);
    }

    /**
     * @param ComponentInterface $subject
     * @param $verb
     * @param array $components
     */
    protected function create(ComponentInterface $subject, $verb, $components = array())
    {
        $action = $this->actionManager->create($subject, $verb, $components);

        $this->actionManager->updateAction($action);
    }

}