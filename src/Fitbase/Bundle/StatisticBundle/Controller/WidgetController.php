<?php

namespace Fitbase\Bundle\StatisticBundle\Controller;

use Fitbase\Bundle\WordpressBundle\Controller\WordpressControllerAbstract;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class WidgetController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function statisticUserAction(Request $request)
    {
        $user = $this->get('user')->current();

        $repositoryVideoStatistic = $this->get('entity_manager')
            ->getRepository('Fitbase\Bundle\StatisticBundle\Entity\UserStatisticExercise');

        $videoCount = $repositoryVideoStatistic->getUserViewCountLastWeek($user->getId(),
            $this->get('datetime')
        );

        return $this->render('FitbaseStatisticBundle:Widget:user.html.twig', array(
            'percentage' => (($videoCount / 21) > 1) ? 100 : floor(($videoCount / 21) * 100)
        ));
    }
}
