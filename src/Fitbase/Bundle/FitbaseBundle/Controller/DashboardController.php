<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 17/03/15
 * Time: 15:19
 */
namespace Fitbase\Bundle\FitbaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class DashboardController extends Controller
{
    /**
     * Display user dashboard
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboardAction(Request $request)
    {
        return $this->render('Fitbase/Dashboard.html.twig', array(
            'company' => $this->get('company')->current()
        ));
    }
}