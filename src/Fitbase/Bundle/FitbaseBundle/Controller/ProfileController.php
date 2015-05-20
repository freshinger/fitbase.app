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


class ProfileController extends Controller
{
    /**
     * Display user dashboard
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function profileAction(Request $request)
    {
        return $this->render('Fitbase/Profile.html.twig', array(
            'company' => $this->get('company')->current()
        ));
    }
}