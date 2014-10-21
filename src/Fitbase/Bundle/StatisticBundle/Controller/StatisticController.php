<?php

namespace Fitbase\Bundle\StatisticBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StatisticController extends Controller
{
    /**
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function statisticUserAction()
    {
        $user = $this->get('fitbase_manager.user')->getCurrentUser();

        $repositoryVideoStatistic = $this->get('fitbase_entity_manager')
            ->getRepository('Fitbase\Bundle\StatisticBundle\Entity\UserStatisticExercise');

        $videoCount = $repositoryVideoStatistic->getUserViewCountLastWeek($user->getId(),
            $this->get('datetime')
        );

        return $this->render('FitbaseStatisticBundle:Statistic:user.html.twig', array(
            'percentage' => (($videoCount / 21) > 1) ? 100 : floor(($videoCount / 21) * 100)
        ));
    }
}
