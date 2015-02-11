<?php

namespace Wellbeing\Bundle\ApiBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Wellbeing\Bundle\ApiBundle\Entity\UserLogin;


class RestApiController extends WsdlApiController
{
    /**
     * Adds a category
     *
     * @ApiDoc(
     *  statusCodes={
     *      200="Returned when successful",
     *      400="Returned when an error has occurred while category creation",
     *      404="Returned when unable to find category"
     *  }
     * )
     * @QueryParam(name="login", requirements="\w+", description="Page for tag list pagination")
     * @QueryParam(name="password", requirements="\w+", description="Page for tag list pagination")
     *
     * @param Request $request A Symfony request
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function getAuthAction(Request $request)
    {
        return $this->get('codegenerator')->code(20);
    }


    /**
     * Adds a category
     *
     * @ApiDoc(
     *  input={"class"="sonata_classification_api_form_category", "name"="", "groups"={"sonata_api_write"}},
     *  output={"class"="Sonata\ClassificationBundle\Model\Category", "groups"={"sonata_api_read"}},
     *  statusCodes={
     *      200="Returned when successful",
     *      400="Returned when an error has occurred while category creation",
     *      404="Returned when unable to find category"
     *  }
     * )
     *
     * @param Request $request A Symfony request
     *
     * @return Category
     *
     * @throws NotFoundHttpException
     */
    public function postStateAction(Request $request)
    {
//        return $this->handleWriteCategory($request);
    }
}
