<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 8/11/14
 * Time: 11:19 AM
 */

namespace Fitbase\Bundle\ReminderBundle\Service;


use Symfony\Component\DependencyInjection\ContainerAware;

class ServiceReminderUser extends ContainerAware
{
    /**
     * Check is user has paused a reminder
     * @param $user
     * @return bool
     */
    public function getIsPause($user)
    {
        $repositoryReminder = $this->container->get('fitbase_entity_manager')
            ->getRepository('Fitbase\Bundle\ReminderBundle\Entity\ReminderUser');

        if (($reminder = $repositoryReminder->findOneByUser($user))) {
            return ($reminder->getPause() > 0);
        }
        return false;
    }

} 