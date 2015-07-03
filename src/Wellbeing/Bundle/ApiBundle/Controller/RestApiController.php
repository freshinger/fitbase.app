<?php

namespace Wellbeing\Bundle\ApiBundle\Controller;

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

        $login = null;
        $password = null;
        $form = $this->createForm(new UserLogin(), array());
        if ($request->get($form->getName())) {
            $form->handleRequest($request);
            if ($form->isValid()) {

                return new JsonResponse([
                    "user_auth" => [
                        "authkey" => $this->get('codegenerator')->code(20),
                        "first_name" => "Wellbeing",
                        "last_name" => "Test user",
                    ]
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
        $entity = new \Wellbeing\Bundle\ApiBundle\Model\UserState();

        $form = $this->createForm(new UserState(), $entity, ['csrf_protection' => false]);


        if ($request->request->get($form->getName())) {
            $form->submit($request->request->get($form->getName()));
            if ($form->isValid()) {

                try {

                    return new JsonResponse(["user_position" => [
                        "correct" => $this->doProcessUserState($entity)
                    ]], 200);

                } catch (\Exception $ex) {

                    $this->get('logger')->crit("{$ex->getMessage()}");

                    return new JsonResponse([
                        "error" => "{$ex->getMessage()}",
                        "user_position" => ["correct" => null],
                    ], 400);
                }
            }

            $this->get('logger')->err("{$form->getErrors()}");

            return new JsonResponse([
                "error" => "{$form->getErrors()}",
                "user_position" => ["correct" => null],
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
    protected function doProcessUserState($entity)
    {
        if (!($user = $this->get('user')->byAuthKey($entity->getAuthKey()))) {
            throw new \LogicException('User not found, Auth-Key does not exists');
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

//
//    /**
//     * Generate projection 1
//     *
//     * @param \Wellbeing\Bundle\ApiBundle\Entity\UserState $userState
//     * @return mixed
//     */
//    protected function preview1(\Wellbeing\Bundle\ApiBundle\Entity\UserState $userState)
//    {
//        $imagick = new \Imagick();
//        $imagick->newImage(400, 400, new \ImagickPixel('transparent'));
//        $imagick->setImageFormat("png");
//
//        $width = $imagick->getImageWidth();
//        $height = $imagick->getImageHeight();
//
//
//        $projectionBuilder = (new ProjectionBuilderXY($width, $height, $userState, false))
//            ->addPatcher((new ProjectionShoulderLeftSpinePatcher())
//                ->setGetX(function (\Wellbeing\Bundle\ApiBundle\Entity\UserState $userState) {
//                    return [
//                        $userState->getShoulderCenter()->getX(),
//                        $userState->getShoulderLeft()->getX(),
//                        $userState->getSpine()->getX(),
//                    ];
//                })->setGetY(function (\Wellbeing\Bundle\ApiBundle\Entity\UserState $userState) {
//                    return [
//                        $userState->getShoulderCenter()->getY(),
//                        $userState->getShoulderLeft()->getY(),
//                        $userState->getSpine()->getY(),
//                    ];
//                }))
//            ->addPatcher((new ProjectionShoulderRightSpinePatcher())
//                ->setGetX(function (\Wellbeing\Bundle\ApiBundle\Entity\UserState $userState) {
//                    return [
//                        $userState->getShoulderCenter()->getX(),
//                        $userState->getShoulderRight()->getX(),
//                        $userState->getSpine()->getX(),
//                    ];
//                })->setGetY(function (\Wellbeing\Bundle\ApiBundle\Entity\UserState $userState) {
//                    return [
//                        $userState->getShoulderCenter()->getY(),
//                        $userState->getShoulderRight()->getY(),
//                        $userState->getSpine()->getY(),
//                    ];
//                }))
//            ->addPatcher((new ProjectionHeadShoulderPatcher())
//                ->setGetX(function (\Wellbeing\Bundle\ApiBundle\Entity\UserState $userState) {
//                    return [
//                        $userState->getShoulderCenter()->getX(),
//                        $userState->getShoulderLeft()->getX(),
//                        $userState->getShoulderRight()->getX(),
//                    ];
//                })->setGetY(function (\Wellbeing\Bundle\ApiBundle\Entity\UserState $userState) {
//                    return [
//                        $userState->getShoulderCenter()->getY(),
//                        $userState->getShoulderLeft()->getY(),
//                        $userState->getShoulderRight()->getY(),
//                    ];
//                }));
//
//        $projection = new \Imagick();
//        $projection->newImage($width, $height, new \ImagickPixel('transparent'));
//        $projection->setImageFormat('png');
//        $projection->drawImage($projectionBuilder->build());
//        $projection->rotateImage(new \ImagickPixel(), 180);
//        $projection->adaptiveResizeImage($width, $height, true);
//        $projection->flopImage();
//
//        $imagick->setImageVirtualPixelMethod(\Imagick::VIRTUALPIXELMETHOD_TRANSPARENT);
//        $imagick->compositeImage($projection, \Imagick::COMPOSITE_DEFAULT, 0, 0);
//
//
//        $name = $this->filename();
//        file_put_contents($name, $imagick);
//
//        $file = new File($name);
//
//        $mediaManager = $this->get('sonata.media.manager.media');
//        $media = $mediaManager->create();
//        $media->setBinaryContent($file);
//        $media->setEnabled(true);
//        $media->setName($file->getFilename());
//        $media->setDescription($file->getFilename());
//        $media->setAuthorName('Wellbeing');
//        $media->setCopyright('Wellbeing');
//        $mediaManager->save($media, 'wellbeing', 'sonata.media.provider.image');
//
//        (new Filesystem())->remove([$file]);
//
//        return $media;
//    }
//
//
//    /**
//     * Generate projection 2
//     * @param \Wellbeing\Bundle\ApiBundle\Entity\UserState $userState
//     * @return mixed
//     */
//    protected function preview2(\Wellbeing\Bundle\ApiBundle\Entity\UserState $userState)
//    {
//        $imagick = new \Imagick();
//        $imagick->newImage(200, 200, new \ImagickPixel('transparent'));
//        $imagick->setImageFormat("png");
//
//
//        $width = $imagick->getImageWidth();
//        $height = $imagick->getImageHeight();
//
//
//        $projectionBuilder = (new ProjectionBuilderXZ($width, $height, $userState, false))
//            ->addPatcher((new ProjectionShoulderLeftSpinePatcher())
//                ->setGetX(function (\Wellbeing\Bundle\ApiBundle\Entity\UserState $userState) {
//                    return [
//                        $userState->getShoulderCenter()->getX(),
//                        $userState->getShoulderLeft()->getX(),
//                        $userState->getSpine()->getX(),
//                    ];
//                })->setGetY(function (\Wellbeing\Bundle\ApiBundle\Entity\UserState $userState) {
//                    return [
//                        $userState->getShoulderCenter()->getZ(),
//                        $userState->getShoulderLeft()->getZ(),
//                        $userState->getSpine()->getZ(),
//                    ];
//                }))
//            ->addPatcher((new ProjectionShoulderRightSpinePatcher())
//                ->setGetX(function (\Wellbeing\Bundle\ApiBundle\Entity\UserState $userState) {
//                    return [
//                        $userState->getShoulderCenter()->getX(),
//                        $userState->getShoulderRight()->getX(),
//                        $userState->getSpine()->getX(),
//                    ];
//                })->setGetY(function (\Wellbeing\Bundle\ApiBundle\Entity\UserState $userState) {
//                    return [
//                        $userState->getShoulderCenter()->getZ(),
//                        $userState->getShoulderRight()->getZ(),
//                        $userState->getSpine()->getZ(),
//                    ];
//                }))
//            ->addPatcher((new ProjectionHeadShoulderPatcher())
//                ->setGetX(function (\Wellbeing\Bundle\ApiBundle\Entity\UserState $userState) {
//                    return [
//                        $userState->getShoulderCenter()->getX(),
//                        $userState->getShoulderLeft()->getX(),
//                        $userState->getShoulderRight()->getX(),
//                    ];
//                })->setGetY(function (\Wellbeing\Bundle\ApiBundle\Entity\UserState $userState) {
//                    return [
//                        $userState->getShoulderCenter()->getZ(),
//                        $userState->getShoulderLeft()->getZ(),
//                        $userState->getShoulderRight()->getZ(),
//                    ];
//                }));
//
//        $projection = new \Imagick();
//        $projection->newImage($width, $height, new \ImagickPixel('transparent'));
//        $projection->setImageFormat('png');
//        $projection->drawImage($projectionBuilder->build());
//        $projection->rotateImage(new \ImagickPixel(), 180);
//        $projection->adaptiveResizeImage($width, $height, true);
//        $projection->flopImage();
//
//        $imagick->setImageVirtualPixelMethod(\Imagick::VIRTUALPIXELMETHOD_TRANSPARENT);
//        $imagick->compositeImage($projection, \Imagick::COMPOSITE_DEFAULT, 0, 0);
//
//        $name = $this->filename();
//        file_put_contents($name, $imagick);
//
//        $file = new File($name);
//
//        $mediaManager = $this->get('sonata.media.manager.media');
//        $media = $mediaManager->create();
//        $media->setBinaryContent($file);
//        $media->setEnabled(true);
//        $media->setName($file->getFilename());
//        $media->setDescription($file->getFilename());
//        $media->setAuthorName('Wellbeing');
//        $media->setCopyright('Wellbeing');
//        $mediaManager->save($media, 'wellbeing', 'sonata.media.provider.image');
//
//        (new Filesystem())->remove([$file]);
//
//        return $media;
//    }
//
//    /**
//     * Generate projection 3
//     * @param \Wellbeing\Bundle\ApiBundle\Entity\UserState $userState
//     * @return mixed
//     */
//    protected function preview3(\Wellbeing\Bundle\ApiBundle\Entity\UserState $userState)
//    {
//        $imagick = new \Imagick();
//        $imagick->newImage(200, 200, new \ImagickPixel('transparent'));
//        $imagick->setImageFormat("png");
//
//
//        $width = $imagick->getImageWidth();
//        $height = $imagick->getImageHeight();
//
//
//        $projectionBuilder = (new ProjectionBuilderYZ($width, $height, $userState, false))
//            ->addPatcher((new ProjectionShoulderLeftSpinePatcher())
//                ->setGetX(function (\Wellbeing\Bundle\ApiBundle\Entity\UserState $userState) {
//                    return [
//                        $userState->getShoulderCenter()->getY(),
//                        $userState->getShoulderLeft()->getY(),
//                        $userState->getSpine()->getY(),
//                    ];
//                })->setGetY(function (\Wellbeing\Bundle\ApiBundle\Entity\UserState $userState) {
//                    return [
//                        $userState->getShoulderCenter()->getZ(),
//                        $userState->getShoulderLeft()->getZ(),
//                        $userState->getSpine()->getZ(),
//                    ];
//                }))
//            ->addPatcher((new ProjectionShoulderRightSpinePatcher())
//                ->setGetX(function (\Wellbeing\Bundle\ApiBundle\Entity\UserState $userState) {
//                    return [
//                        $userState->getShoulderCenter()->getY(),
//                        $userState->getShoulderRight()->getY(),
//                        $userState->getSpine()->getY(),
//                    ];
//                })->setGetY(function (\Wellbeing\Bundle\ApiBundle\Entity\UserState $userState) {
//                    return [
//                        $userState->getShoulderCenter()->getZ(),
//                        $userState->getShoulderRight()->getZ(),
//                        $userState->getSpine()->getZ(),
//                    ];
//                }))
//            ->addPatcher((new ProjectionHeadShoulderPatcher())
//                ->setGetX(function (\Wellbeing\Bundle\ApiBundle\Entity\UserState $userState) {
//                    return [
//                        $userState->getShoulderCenter()->getY(),
//                        $userState->getShoulderLeft()->getY(),
//                        $userState->getShoulderRight()->getY(),
//                    ];
//                })->setGetY(function (\Wellbeing\Bundle\ApiBundle\Entity\UserState $userState) {
//                    return [
//                        $userState->getShoulderCenter()->getZ(),
//                        $userState->getShoulderLeft()->getZ(),
//                        $userState->getShoulderRight()->getZ(),
//                    ];
//                }));
//
//        $projection = new \Imagick();
//        $projection->newImage($width, $height, new \ImagickPixel('transparent'));
//        $projection->setImageFormat('png');
//        $projection->drawImage($projectionBuilder->build());
//        $projection->rotateImage(new \ImagickPixel(), 180);
//        $projection->adaptiveResizeImage($width, $height, true);
//        $projection->flopImage();
//
//        $imagick->setImageVirtualPixelMethod(\Imagick::VIRTUALPIXELMETHOD_TRANSPARENT);
//        $imagick->compositeImage($projection, \Imagick::COMPOSITE_DEFAULT, 0, 0);
//
//        $name = $this->filename();
//        file_put_contents($name, $imagick);
//
//        $file = new File($name);
//
//        $mediaManager = $this->get('sonata.media.manager.media');
//        $media = $mediaManager->create();
//        $media->setBinaryContent($file);
//        $media->setEnabled(true);
//        $media->setName($file->getFilename());
//        $media->setDescription($file->getFilename());
//        $media->setAuthorName('Wellbeing');
//        $media->setCopyright('Wellbeing');
//        $mediaManager->save($media, 'wellbeing', 'sonata.media.provider.image');
//
//        (new Filesystem())->remove([$file]);
//
//        return $media;
//    }
//
//    protected function filename()
//    {
//        return "/tmp/" . md5(rand(0, 999999)) . ".png";
//    }
}
