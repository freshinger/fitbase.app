<?php

namespace Fitbase\Bundle\StatisticBundle\Controller;

use Fitbase\Bundle\WordpressBundle\Controller\WordpressControllerAbstract;
use Symfony\Component\HttpFoundation\Request;

class WidgetController extends WordpressControllerAbstract
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function statisticUserAction(Request $request)
    {
        $user = $this->get('fitbase_manager.user')->getCurrentUser();

        $repositoryVideoStatistic = $this->get('fitbase_entity_manager')
            ->getRepository('Fitbase\Bundle\StatisticBundle\Entity\UserStatisticVideo');

        $videoCount = $repositoryVideoStatistic->getUserViewCountLastWeek($user->getId(),
            $this->get('datetime')
        );

        return $this->render('FitbaseStatisticBundle:Widget:user.html.twig', array(
            'percentage' => (($videoCount / 21) > 1) ? 100 : floor(($videoCount / 21) * 100)
        ));
    }
}
