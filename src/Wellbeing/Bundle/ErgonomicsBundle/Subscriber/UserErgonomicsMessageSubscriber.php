<?php

namespace Wellbeing\Bundle\ErgonomicsBundle\Subscriber;


use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsMessage;
use Wellbeing\Bundle\ErgonomicsBundle\Event\UserErgonomicsMessageEvent;
use Wellbeing\Bundle\ErgonomicsBundle\Event\UserStateErgonomicsEvent;

class UserErgonomicsMessageSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        return [
            'wellbeing.user_state_ergonomics_create' => ['onUserStateErgonomicsCreate', -127],
            'wellbeing.user_ergonomics_message_done' => ['onUserErgonomicsMessageDone'],
        ];
    }


    /**
     * Get measure interval
     *
     * @return int
     */
    protected function getMeasureIntervalInMinutes()
    {
        return 3;
    }

    /**
     *
     * @param UserStateErgonomicsEvent $event
     */
    public function onUserStateErgonomicsCreate(UserStateErgonomicsEvent $event)
    {
        $datetime = $this->container->get('datetime');
        $entityManager = $this->container->get('entity_manager');
        $serviceErgonomics = $this->container->get('wellbeing.ergonomics');

        if (!($userState = $event->getEntity())) {
            throw new \LogicException('User state ergonomics object does not exists');
        }

        if (!($user = $event->getEntity()->getUser())) {
            throw new \LogicException('User can not be empty');
        }

        $dateFirst = $datetime->getDateTime('now');
        $dateFirst->modify("-{$this->getMeasureIntervalInMinutes()} min");
        $dateLast = $datetime->getDateTime('now');

        $repository = $entityManager->getRepository('Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomics');
        if (($collection = $repository->getByInterval($user, $dateFirst, $dateLast))) {

            $first = $collection->first();
            $last = $collection->last();

            $intervalReal = $this->getIntervalInMinutes(
                $last->getDate(),
                $first->getDate()
            );
            // Check interval between first and last positions
            // to verify that required count of positions is full
            if ($intervalReal == $this->getMeasureIntervalInMinutes()) {

                $entity = (new UserErgonomicsMessage())
                    ->setUser($user)
                    ->setDate($datetime->getDateTime())
                    ->setProcessed(false)
                    ->setCorrect($serviceErgonomics->check($collection))
                    ->setErgonomics($collection);

                $entityManager->persist($entity);
                $entityManager->flush();
            }
        }
    }

    /**
     * @param $date1
     * @param $date2
     * @return float|int
     */
    protected function getIntervalInMinutes($date1, $date2)
    {
        if (($interval = $date1->getTimestamp() - $date2->getTimestamp())) {
            return (int)round($interval / 60);
        }
        return 0;
    }

    /**
     * Mark message as processed
     * @param UserErgonomicsMessageEvent $event
     */
    public function onUserErgonomicsMessageDone(UserErgonomicsMessageEvent $event)
    {
        $datetime = $this->container->get('datetime');
        $entityManager = $this->container->get('entity_manager');

        if (!($entity = $event->getEntity())) {
            throw new \LogicException('User ergonomics message object does not exists');
        }

        $entity->setProcessed(true);
        $entity->setProcessedDate($datetime->getDateTime());

        $entityManager->persist($entity);
        $entityManager->flush($entity);
    }
}