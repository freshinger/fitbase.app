<?php

namespace Wellbeing\Bundle\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BeSimple\SoapBundle\ServiceDefinition\Annotation as Soap;

class WsdlApiController extends Controller
{
    /**
     * @Soap\Method("addState")
     * @Soap\Param("timestamp", phpType = "int")
     * @Soap\Param("head", phpType = "float[]")
     * @Soap\Param("shoulderCenter", phpType = "float[]")
     * @Soap\Param("shoulderLeft", phpType = "float[]")
     * @Soap\Param("shoulderRight", phpType = "float[]")
     * @Soap\Param("elbowLeft", phpType = "float[]")
     * @Soap\Param("elbowRight", phpType = "float[]")
     * @Soap\Param("handLeft", phpType = "float[]")
     * @Soap\Param("handRight", phpType = "float[]")
     * @Soap\Param("com", phpType = "float[]")
     * @Soap\Param("spine", phpType = "float[]")
     * @Soap\Param("hipLeft", phpType = "float[]")
     * @Soap\Param("hipRight", phpType = "float[]")
     * @Soap\Param("kneeLeft", phpType = "float[]")
     * @Soap\Param("kneeRight", phpType = "float[]")
     * @Soap\Param("footLeft", phpType = "float[]")
     * @Soap\Param("footRight", phpType = "float[]")
     * @Soap\Result(phpType = "string")
     */
    public function addStateAction($timestamp = null, $head = array(), $shoulderCenter = array(), $shoulderLeft = array(),
                                   $shoulderRight = array(), $elbowLeft = array(), $elbowRight = array(), $handLeft = array(),
                                   $handRight = array(), $com = array(), $spine = array(), $hipLeft = array(), $hipRight = array(),
                                   $kneeLeft = array(), $kneeRight = array(), $footLeft = array(), $footRight = array())
    {


        return $this->container->get('besimple.soap.response')->setReturnValue(sprintf('Hello %s!', $timestamp));
    }
}
