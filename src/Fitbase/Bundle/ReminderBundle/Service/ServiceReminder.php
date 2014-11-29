<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 8/11/14
 * Time: 11:19 AM
 */

namespace Fitbase\Bundle\ReminderBundle\Service;


use Symfony\Component\DependencyInjection\ContainerAware;

class ServiceReminder extends ContainerAware
{
    /**
     * @param null $day
     * @return mixed
     */
    public function getItemsExercise($day = null)
    {
        $entityManager = $this->container->get('entity_manager');
        $repositoryReminderUserItem = $entityManager->getRepository('Fitbase\Bundle\ReminderBundle\Entity\ReminderUserItem');
        return $repositoryReminderUserItem->findAllNotPausedByDayAndType($day, 'exercise');
    }

    /**
     * @param null $day
     * @return mixed
     */
    public function getItemsWeeklytask($day = null)
    {
        $entityManager = $this->container->get('entity_manager');
        $repositoryReminderUserItem = $entityManager->getRepository('Fitbase\Bundle\ReminderBundle\Entity\ReminderUserItem');
        return $repositoryReminderUserItem->findAllNotPausedByDayAndType($day, 'weeklytask');
    }
}