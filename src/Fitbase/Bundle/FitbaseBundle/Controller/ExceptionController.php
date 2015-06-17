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


class ExceptionController extends Controller
{
    /**
     * Display user dashboard
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function exception404Action(Request $request, $exception)
    {
        return $this->render('Exception/404.html.twig', [
            'exception' => $exception
        ]);
    }
}