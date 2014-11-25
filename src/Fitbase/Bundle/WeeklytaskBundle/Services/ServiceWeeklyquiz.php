<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Services;

use Symfony\Component\DependencyInjection\ContainerAware;

class ServiceWeeklyquiz extends ContainerAware
{
    /**
     * @param $datetime
     * @return mixed
     */
    public function toSend($datetime)
    {
        $entityManager = $this->container->get('entity_manager');
        $repositoryWeeklytaskUser = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser');
        return $repositoryWeeklytaskUser->findAllNotProcessedByDateTime($datetime);
    }
}