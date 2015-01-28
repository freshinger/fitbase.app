<?php

namespace Fitbase\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BeSimple\SoapBundle\ServiceDefinition\Annotation as Soap;

class WsdlController extends Controller
{
    /**
     * @Soap\Method("login")
     * @Soap\Param("code", phpType = "string")
     * @Soap\Param("login", phpType = "string")
     * @Soap\Param("password", phpType = "string")
     * @Soap\Result(phpType = "string")
     */
    public function loginAction($code, $login, $password)
    {
        return $this->container->get('besimple.soap.response')->setReturnValue(sprintf('Hello %s!', $login));
    }

//    /**
//     * @Soap\Method("goodbye")
//     * @Soap\Param("name", phpType = "string")
//     * @Soap\Result(phpType = "string")
//     */
//    public function goodbyeAction($name)
//    {
//        return $this->container->get('besimple.soap.response')->setReturnValue(sprintf('Goodbye %s!', $name));
//    }
}
