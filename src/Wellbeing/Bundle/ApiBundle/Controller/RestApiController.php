<?php

namespace Wellbeing\Bundle\ApiBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Wellbeing\Bundle\ApiBundle\Form\UserAuth;
use Wellbeing\Bundle\ApiBundle\Form\UserLogin;
use Wellbeing\Bundle\ApiBundle\Form\UserState;
use Wellbeing\Bundle\ApiBundle\Imagick\Patcher\ProjectionHeadShoulderPatcher;
use Wellbeing\Bundle\ApiBundle\Imagick\Patcher\ProjectionShoulderLeftSpinePatcher;
use Wellbeing\Bundle\ApiBundle\Imagick\Patcher\ProjectionShoulderRightSpinePatcher;
use Wellbeing\Bundle\ApiBundle\Imagick\Patcher\ProjectionSpineShoulderPatcher;
use Wellbeing\Bundle\ApiBundle\Imagick\ProjectionBuilderXY;
use Wellbeing\Bundle\ApiBundle\Imagick\ProjectionBuilderXZ;
use Wellbeing\Bundle\ApiBundle\Imagick\ProjectionBuilderYZ;


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
        $form = $this->createForm(new UserState(),
            (new \Wellbeing\Bundle\ApiBundle\Entity\UserState())
                ->setDate($this->get('datetime')->getDateTime('now'))
            , array('csrf_protection' => false));

        if ($request->request->get($form->getName())) {
            $form->submit($request->request->get($form->getName()));
            if ($form->isValid()) {



//                // TODO: replace to correct user from auth key
//                if (($userState = $form->getData())) {
//
//                    $this->get('logger')->err("UserState received: {$userState->getId()}");
//
//                    $entityManager = $this->get('entity_manager');
//                    $repositoryUser = $entityManager->getRepository('Application\Sonata\UserBundle\Entity\User');
//                    $userState->setUser($repositoryUser->find(1));
//
////                    $userState->setPreview1($this->preview1($userState));
////                    $userState->setPreview2($this->preview2($userState));
////                    $userState->setPreview3($this->preview3($userState));
//
//                    $this->get('entity_manager')->persist($userState);
//                    $this->get('entity_manager')->flush($userState);
//
//                    $this->get('logger')->err("UserState inserted: {$userState->getId()}");
//
//                }


                return new JsonResponse(["user_position" => [
                    "correct" => true
                ]], 500);

            }


            return new JsonResponse('Validation failure. Check format of your fields.', 400);
        }

        return new JsonResponse('Authentication code not found', 404);
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
