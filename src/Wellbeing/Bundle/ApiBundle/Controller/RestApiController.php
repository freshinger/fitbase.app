<?php

namespace Wellbeing\Bundle\ApiBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Wellbeing\Bundle\ApiBundle\Form\UserAuth;
use Wellbeing\Bundle\ApiBundle\Form\UserLogin;
use Wellbeing\Bundle\ApiBundle\Form\UserState;


class RestApiController extends WsdlApiController
{
    /**
     * Get authentication code
     *
     * @ApiDoc(
     *  input="Wellbeing\Bundle\ApiBundle\Form\UserLogin",
     *  output="Wellbeing\Bundle\ApiBundle\Form\UserAuth",
     *  statusCodes={
     *      200="Returned when successful",
     *      400="Returned when an error has occurred while authentication",
     *      404="Returned when unable to find username or password"
     *  }
     * )
     * @param Request $request A Symfony request
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function postLogonAction(Request $request)
    {
        $login = null;
        $password = null;
        $form = $this->createForm(new UserLogin(), array());
        if ($request->get($form->getName())) {
            $form->handleRequest($request);
            if ($form->isValid()) {

                return new JsonResponse([
                    "user_auth" => [
                        "authkey" => $this->get('codegenerator')->code(20)]
                ]);

            }
        }
        return new JsonResponse("The username or password you entered is incorrect. Please try again.", 404);
    }

    /**
     * Log On function, return authentication code
     * to identify application with user
     *
     * @ApiDoc(
     *  input="Wellbeing\Bundle\ApiBundle\Form\UserAuth",
     *  output="Wellbeing\Bundle\ApiBundle\Form\Status",
     *  statusCodes={
     *      200="Returned when successful",
     *      400="Returned when an error has occurred while logout process",
     *      404="Returned when unable to find authentication key"
     *  }
     * )
     * @param Request $request A Symfony request
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function postLogoutAction(Request $request)
    {
        $login = null;
        $password = null;
        $form = $this->createForm(new UserAuth(), array());
        if ($request->get($form->getName())) {
            $form->handleRequest($request);
            if ($form->isValid()) {

                return new JsonResponse(["status" => [
                    "message" => "OK",
                ]], 200);

            }
        }
        return new JsonResponse("Authentication code not found", 404);
    }

    /**
     * Store user position
     *
     * @ApiDoc(
     *  input="Wellbeing\Bundle\ApiBundle\Form\UserState",
     *  output="Wellbeing\Bundle\ApiBundle\Form\UserPosition",
     *  statusCodes={
     *      200="Returned when successful",
     *      400="Returned when an error has occurred while user-state creation",
     *      404="Returned when unable to find authentication key"
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
        $form = $this->createForm(new UserState(),
            (new \Wellbeing\Bundle\ApiBundle\Entity\UserState())
                ->setDate($this->get('datetime')->getDateTime('now'))
            , array('csrf_protection' => false));

        if ($request->request->get($form->getName())) {
            $form->submit($request->request->get($form->getName()));
            if ($form->isValid()) {

                // TODO: replace to correct user from auth key
                $repositoryUser = $this->get('entity_manager')->getRepository('Application\Sonata\UserBundle\Entity\User');
                $form->getData()->setUser($repositoryUser->find(1));

                $this->get('entity_manager')->persist($form->getData());
                $this->get('entity_manager')->flush($form->getData());

                return new JsonResponse(["user_position" => [
                    "correct" => true
                ]], 500);

            }

            \file_put_contents('/tmp/putStateAction.log', json_encode(($form->getData())) . "\n");

            return new JsonResponse('Validation failure. Check format of your fields.', 400);
        }

        return new JsonResponse('Authentication code not found', 404);
    }
}
