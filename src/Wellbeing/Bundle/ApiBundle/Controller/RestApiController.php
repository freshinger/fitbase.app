<?php

namespace Wellbeing\Bundle\ApiBundle\Controller;

use LogicException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Wellbeing\Bundle\ApiBundle\Form\UserAuth;
use Wellbeing\Bundle\ApiBundle\Form\UserLogin;
use Wellbeing\Bundle\ApiBundle\Form\UserState;
use Wellbeing\Bundle\ApiBundle\Imagick\Patcher\ProjectionSpineShoulderPatcher;

class RestApiController extends WsdlApiController
{
    /**
     * Get authentication code
     *
     * @ApiDoc(
     *  input="Wellbeing\Bundle\ApiBundle\Form\UserLogin",
     *  output="Wellbeing\Bundle\ApiBundle\Form\User",
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
        $entity = new \Wellbeing\Bundle\ApiBundle\Model\UserLogin();
        $form = $this->createForm(new UserLogin(), $entity);
        if ($request->get($form->getName())) {
            $form->handleRequest($request);
            if ($form->isValid()) {

                if (($authentication = $this->doLogon($entity))) {
                    return new JsonResponse([
                        "user_auth" => [
                            "authkey" => $authentication->getCode(),
                            "first_name" => $authentication->getUser()->getFirstName(),
                            "last_name" => $authentication->getUser()->getLastName(),
                        ]
                    ]);
                }

                return new JsonResponse([
                    "user_auth" => [
                        "authkey" => null,
                        "first_name" => null,
                        "last_name" => null,
                        "error" => "User name or password is wrong",
                    ]
                ]);
            }
        }
        return new JsonResponse("The username or password you entered is incorrect. Please try again.", 404);
    }

    /**
     * Do a sing in logic
     *
     * @param \Wellbeing\Bundle\ApiBundle\Model\UserLogin $entity
     * @return null
     */
    public function doLogon(\Wellbeing\Bundle\ApiBundle\Model\UserLogin $entity)
    {
        $userManager = $this->get('fos_user.user_manager');
        if (($user = $userManager->findUserByUsernameOrEmail($entity->getLogin()))) {

            $encoder = $this->get('security.encoder_factory')->getEncoder($user);
            if ($encoder->isPasswordValid($user->getPassword(), $entity->getPassword(), $user->getSalt())) {

                $code = $this->get('codegenerator')->code(20);
                if (!($authentication = $this->get('wellbeing.authentication')->start($user, $code))) {
                    throw new LogicException('Authentication object can not be empty');
                }

                return $authentication;
            }
        }

        return null;
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
        $entity = new \Wellbeing\Bundle\ApiBundle\Model\UserAuth();
        $form = $this->createForm(new UserAuth(), $entity);
        if ($request->get($form->getName())) {
            $form->handleRequest($request);
            if ($form->isValid()) {

                try {

                    $this->doLogout($entity);

                    return new JsonResponse([
                        "message" => "OK",
                    ], 200);

                } catch (\Exception $ex) {

                    $this->get('logger')->crit("{$ex->getMessage()}");

                    return new JsonResponse([
                        "message" => "OK",
                        "error" => "{$ex->getMessage()}",
                    ], 400);
                }
            }
        }
        return new JsonResponse("Authentication code not found", 404);
    }

    /**
     *
     * @param \Wellbeing\Bundle\ApiBundle\Model\UserAuth $entity
     * @return JsonResponse
     */
    protected function doLogout(\Wellbeing\Bundle\ApiBundle\Model\UserAuth $entity)
    {
        if (!$this->get('wellbeing.authentication')->close($entity->getAuthkey())) {
            throw new LogicException('Authentication object can not be closed');
        }

        return true;
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
        $entity = new \Wellbeing\Bundle\ApiBundle\Model\UserState();
        $form = $this->createForm(new UserState(), $entity, ['csrf_protection' => false]);
        if ($request->request->get($form->getName())) {
            $form->submit($request->request->get($form->getName()));
            if ($form->isValid()) {

                try {

                    return new JsonResponse(["user_position" => [
                        "correct" => $this->doState($entity)
                    ]], 200);

                } catch (\Exception $ex) {

                    $this->get('logger')->crit("{$ex->getMessage()}");

                    return new JsonResponse([
                        "user_position" => ["correct" => null],
                        "error" => "{$ex->getMessage()}",
                    ], 400);
                }
            }

            $this->get('logger')->err("{$form->getErrors()}");

            return new JsonResponse([
                "user_position" => ["correct" => null],
                "error" => "{$form->getErrors()}",
            ], 400);
        }

        return new JsonResponse([
            "error" => 'Wrong JSON Format',
            "user_position" => ["correct" => null],
        ], 404);
    }

    /**
     * Process user state
     * @param $entity
     * @return bool
     */
    protected function doState($entity)
    {
        $serviceAuthentication = $this->get('wellbeing.authentication');
        if (!($authentication = $serviceAuthentication->find($entity->getAuthKey()))) {
            throw new \LogicException('Authentication object can not be empty');
        }

        if (!($user = $authentication->getUser())) {
            throw new \LogicException('User object can not be empty');
        }

        if ($entity->getTicketType() == 'T1') {
            return $this->get('wellbeing.ergonomics')
                ->state($user, $entity);
        }

        if ($entity->getTicketType() == 'T2') {
            return $this->get('wellbeing.stress')
                ->state($user, $entity);
        }

        if ($entity->getTicketType() == 'T3') {
            return $this->get('wellbeing.exercise')
                ->state($user, $entity);
        }

        return false;
    }
}
