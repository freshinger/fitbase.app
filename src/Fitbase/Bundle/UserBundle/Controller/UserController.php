<?php

namespace Fitbase\Bundle\UserBundle\Controller;

use Sonata\AdminBundle\Controller\CoreController;
use Symfony\Component\HttpFoundation\Request;


class UserController extends CoreController
{
    public function removeAction(Request $request)
    {
        return $this->render('User/Remove.html.twig', array());
    }
}
