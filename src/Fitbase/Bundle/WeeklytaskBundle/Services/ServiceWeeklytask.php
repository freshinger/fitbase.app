<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Services;

use Symfony\Component\DependencyInjection\ContainerAware;

class ServiceWeeklytask extends ContainerAware
{
    /**
     * @param $datetime
     * @return mixed
     */
    public function toSend($datetime)
    {
        $entityManager = $this->container->get('entity_manager');
        $repositoryWeeklytaskUser = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser');
        return $repositoryWeeklytaskUser->findAllNotProcessedByDateTime($datetime);
    }


    /**
     * Get nex weekly task with respect to category, priority
     * and already done tasks
     * @param $user
     * @param $focus
     * @return mixed
     */
    public function getNextByFocus($user, $focus, $datetime)
    {
        $entityManager = $this->container->get('entity_manager');
        $repositoryWeeklytask = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask');
        $repositoryWeeklytaskUser = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser');
        if (!$repositoryWeeklytaskUser->findOneByUserAndDateTime($user, $datetime)) {
            // TODO: refactoring to reduce sql queries
            if (($collection = $repositoryWeeklytask->findOneNexByUserAndCategory($user, $focus))) {
                foreach ($collection as $weeklytask) {
                    if (!$repositoryWeeklytaskUser->findOneByUserAndTask($user, $weeklytask)) {
                        return $weeklytask;
                    }
                }
            }


            return $repositoryWeeklytask->findOneNexByUserAndCategory($user, $focus);
        }
        return null;
    }

    /**
     * Get nex weekly task with respect to priority
     * and already done tasks
     * @param $user
     * @return mixed
     */
    public function getNextRandom($user, $datetime)
    {
        $entityManager = $this->container->get('entity_manager');
        $repositoryWeeklytask = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask');
        $repositoryWeeklytaskUser = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser');
        if (!$repositoryWeeklytaskUser->findOneByUserAndDateTime($user, $datetime)) {
            return $repositoryWeeklytask->findOneNextByUser($user);
        }
        return null;
    }


    /**
     * Get first start date
     * @param $user
     * @return int
     */
    public function getUserFirstDate($user)
    {
        $date = $user->getRegistered();
        $date->setTimezone(
            $this->container->get('datetime')
                ->getDateTimeZone()
        );

        $date->modify("midnight next monday");
        $date->setTime(0, 0, 0);

        return $date;
    }

    /**
     * Get user next date
     * @param $user
     * @return \DateTime
     */
    public function getUserNextDate($user)
    {
        $datetime = $this->container
            ->get('datetime');

        $date = $datetime->getDateTime('now');
        $date->modify("midnight next monday");
        $date->setTime(0, 0, 0);

        return $date;
    }


    /**
     * Get date using a post with position
     * @param $user
     * @param $post
     * @return string
     */
    public function getPostNextDate($user, $post)
    {
        if (!empty($post)) {
            $interval = 7 * 24 * 60 * 60 * (int)$post->getMetaValue('week');
            return $this->getUserFirstDate($user)->modify("+ $interval seconds");
        }
        return null;
    }
}