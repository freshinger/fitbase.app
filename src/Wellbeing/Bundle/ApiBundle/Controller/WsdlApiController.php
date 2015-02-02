<?php

namespace Wellbeing\Bundle\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BeSimple\SoapBundle\ServiceDefinition\Annotation as Soap;
use Wellbeing\Bundle\ApiBundle\Entity\UserState;

class WsdlApiController extends Controller
{
    /**
     * @Soap\Method("addState")
     * @Soap\Param("authkey", phpType = "string")
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
     * @Soap\Result(phpType = "boolean")
     */
    public function addStateAction($authkey = null, $timestamp = null, $head = array(), $shoulderCenter = array(), $shoulderLeft = array(),
                                   $shoulderRight = array(), $elbowLeft = array(), $elbowRight = array(), $handLeft = array(),
                                   $handRight = array(), $com = array(), $spine = array(), $hipLeft = array(), $hipRight = array(),
                                   $kneeLeft = array(), $kneeRight = array(), $footLeft = array(), $footRight = array())
    {

        $entity = new UserState();
        $entity->setAuthkey($authkey);
        $entity->setTimestamp($timestamp);
        $entity->setHead($head);
        $entity->setShoulderCenter($shoulderCenter);
        $entity->setShoulderLeft($shoulderLeft);
        $entity->setShoulderRight($shoulderRight);
        $entity->setElbowLeft($elbowLeft);
        $entity->setElbowRight($elbowRight);
        $entity->setHandLeft($handLeft);
        $entity->setHandRight($handRight);
        $entity->setCom($com);
        $entity->setSpine($spine);
        $entity->setHipLeft($hipLeft);
        $entity->setHipRight($hipRight);
        $entity->setKneeLeft($kneeLeft);
        $entity->setKneeRight($kneeRight);
        $entity->setFootLeft($footLeft);
        $entity->setFootRight($footRight);

        $validator = $this->get('validator');
        if (count(($errors = $validator->validate($entity)))) {
            throw new \SoapFault('validation error', $errors->__toString());
        }

        return $this->container->get('besimple.soap.response')->setReturnValue(true);
    }
}
