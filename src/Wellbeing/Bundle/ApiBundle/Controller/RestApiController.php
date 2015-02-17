<?php

namespace Wellbeing\Bundle\ApiBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Wellbeing\Bundle\ApiBundle\Entity\UserLogin;
use Wellbeing\Bundle\ApiBundle\Form\UserAuth;


class RestApiController extends WsdlApiController
{
    /**
     * Get authentication code, deprecated, use GET auth
     *
     * @ApiDoc(
     *  input="Wellbeing\Bundle\ApiBundle\Form\UserLogin",
     *  output="Wellbeing\Bundle\ApiBundle\Form\UserAuth",
     *  statusCodes={
     *      200="Returned when successful",
     *      400="Returned when an error has occurred while category creation",
     *      404="Returned when unable to find category"
     *  }
     * )
     * @param Request $request A Symfony request
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function postAuthAction(Request $request)
    {
        return ["user_auth" => ["authkey" => $this->get('codegenerator')->code(20)]];
    }


    /**
     * Get authentication code
     *
     * @ApiDoc(
     *  input="Wellbeing\Bundle\ApiBundle\Form\UserLogin",
     *  output="Wellbeing\Bundle\ApiBundle\Form\UserAuth",
     *  statusCodes={
     *      200="Returned when successful",
     *      400="Returned when an error has occurred while category creation",
     *      404="Returned when unable to find category"
     *  }
     * )
     * @param Request $request A Symfony request
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function getAuthAction(Request $request)
    {
        return ["user_auth" => ["authkey" => $this->get('codegenerator')->code(20)]];
    }

    /**
     * Log On function, return authentication code
     * to identify application with user
     *
     * @ApiDoc(
     *  input="Wellbeing\Bundle\ApiBundle\Form\UserAuth",
     *  statusCodes={
     *      200="Returned when successful",
     *      400="Returned when an error has occurred while category creation",
     *      404="Returned when unable to find category"
     *  }
     * )
     * @param Request $request A Symfony request
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function deleteAuthAction(Request $request)
    {
        return ["user_auth" => ["authkey" => $this->get('codegenerator')->code(20)]];
    }


    /**
     * Store user position
     *
     * @ApiDoc(
     *  input="Wellbeing\Bundle\ApiBundle\Form\UserState",
     *  output="Wellbeing\Bundle\ApiBundle\Form\UserPosition",
     *  statusCodes={
     *      200="Returned when successful",
     *      400="Returned when an error has occurred while category creation",
     *      404="Returned when unable to find category"
     *  }
     * )
     * @param Request $request A Symfony request
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function putStateAction(Request $request)
    {
        return ["user_position" => ["correct" => true]];
    }
}
