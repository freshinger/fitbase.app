<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Services;

use Symfony\Component\DependencyInjection\ContainerAware;

class ServiceWeeklytask extends ContainerAware
{
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