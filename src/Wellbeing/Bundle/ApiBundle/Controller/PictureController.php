<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 27/04/15
 * Time: 10:54
 */

namespace Wellbeing\Bundle\ApiBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Wellbeing\Bundle\ApiBundle\Imagick\Patcher\ProjectionHeadShoulderPatcher;
use Wellbeing\Bundle\ApiBundle\Imagick\Patcher\ProjectionSpineShoulderPatcher;
use Wellbeing\Bundle\ApiBundle\Imagick\ProjectionBuilderXY;
use Wellbeing\Bundle\ApiBundle\Imagick\ProjectionBuilderXZ;
use Wellbeing\Bundle\ApiBundle\Imagick\ProjectionBuilderYZ;

class PictureController extends Controller
{
    protected $xMax;
    protected $yMax;
    protected $width;
    protected $height;

    /**
     * Display company forest
     * @param Request $request
     * @return Response
     */
    public function stateAction(Request $request, $unique = null)
    {
        $imagick = new \Imagick();
        $imagick->setBackgroundColor(new \ImagickPixel('transparent'));
        $imagick->readImageFile(fopen($this->get('kernel')->getRootDir() .
                '/Resources/views/' .
                'Wellbeing/UserState/background.jpg', 'r')
        );


        $imagick->scaleImage(300, 0);
        $imagick->setImageFormat("png");


        $entityManager = $this->get('entity_manager');
        $repositoryUserState = $entityManager->getRepository('Wellbeing\Bundle\ApiBundle\Entity\UserState');
        if (($userState = $repositoryUserState->find($unique))) {

            $width = $imagick->getImageWidth();
            $height = $imagick->getImageHeight();


            $draw = new \ImagickDraw();
            $draw->setFillColor('#909090');
            $draw->line($width / 2, 0, $width / 2, $height);
            $imagick->drawImage($draw);

            $draw = new \ImagickDraw();
            $draw->setFillColor('#909090');
            $draw->line(0, $height / 2, $width, $height / 2);
            $imagick->drawImage($draw);


            $projection = new \Imagick();
            $projection->newImage($width / 2, $height / 2, new \ImagickPixel('transparent'));
            $projection->setImageFormat('png');
            $projection->drawImage(new ProjectionBuilderXY($width / 2, $height / 2, $userState));
            $projection->rotateImage(new \ImagickPixel(), 180);
            $projection->adaptiveResizeImage($width / 2, $height / 2, true);

            $imagick->setImageVirtualPixelMethod(\Imagick::VIRTUALPIXELMETHOD_TRANSPARENT);
            $imagick->compositeImage($projection, \Imagick::COMPOSITE_DEFAULT, 0, 0);


            $projection = new \Imagick();
            $projection->newImage($width / 2, $height / 2, new \ImagickPixel('transparent'));
            $projection->setImageFormat('png');
            $projection->drawImage(new ProjectionBuilderXZ($width / 2, $height / 2, $userState));
            $projection->rotateImage(new \ImagickPixel(), -90);
            $projection->adaptiveResizeImage($width / 2, $height / 2, true);

            $imagick->setImageVirtualPixelMethod(\Imagick::VIRTUALPIXELMETHOD_TRANSPARENT);
            $imagick->compositeImage($projection, \Imagick::COMPOSITE_DEFAULT, $width / 2, $height / 2);

            $projection = new \Imagick();
            $projection->newImage($width / 2, $height / 2, new \ImagickPixel('transparent'));
            $projection->setImageFormat('png');
            $projection->drawImage(new ProjectionBuilderYZ($width / 2, $height / 2, $userState));
            $projection->rotateImage(new \ImagickPixel('transparent'), 270);
            $projection->adaptiveResizeImage($width / 2, $height / 2, true);

            $imagick->setImageVirtualPixelMethod(\Imagick::VIRTUALPIXELMETHOD_TRANSPARENT);
            $imagick->compositeImage($projection, \Imagick::COMPOSITE_DEFAULT, $width / 2, 0);
        }


        return new Response($imagick, 200, array(
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'inline; filename="state.png"'
        ));
    }

    /**
     * @param Request $request
     * @param null $unique
     * @return Response
     */
    public function stateXYAction(Request $request, $unique = null)
    {
        $imagick = new \Imagick();
        $imagick->setBackgroundColor(new \ImagickPixel('transparent'));
        $imagick->readImageFile(fopen($this->get('kernel')->getRootDir() .
                '/Resources/views/' .
                'Wellbeing/UserState/background.jpg', 'r')
        );


        $imagick->scaleImage(150, 0);
        $imagick->setImageFormat("png");


        $entityManager = $this->get('entity_manager');
        $repositoryUserState = $entityManager->getRepository('Wellbeing\Bundle\ApiBundle\Entity\UserState');
        if (($userState = $repositoryUserState->find($unique))) {

            $width = $imagick->getImageWidth();
            $height = $imagick->getImageHeight();

            $projectionBuilder = new ProjectionBuilderXY($width, $height, $userState, false);
            $projectionBuilder->addPatcher(new ProjectionSpineShoulderPatcher())
                ->addPatcher(new ProjectionHeadShoulderPatcher());


            $projection = new \Imagick();
            $projection->newImage($width, $height, new \ImagickPixel('transparent'));
            $projection->setImageFormat('png');
            $projection->drawImage($projectionBuilder->build());
            $projection->rotateImage(new \ImagickPixel(), 180);
            $projection->adaptiveResizeImage($width, $height, true);

            $imagick->setImageVirtualPixelMethod(\Imagick::VIRTUALPIXELMETHOD_TRANSPARENT);
            $imagick->compositeImage($projection, \Imagick::COMPOSITE_DEFAULT, 0, 0);
        }


        return new Response($imagick, 200, array(
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'inline; filename="state.png"'
        ));
    }

    /**
     *
     * @param Request $request
     * @param null $unique
     * @return Response
     */
    public function stateXZAction(Request $request, $unique = null)
    {
        $imagick = new \Imagick();
        $imagick->setBackgroundColor(new \ImagickPixel('transparent'));
        $imagick->readImageFile(fopen($this->get('kernel')->getRootDir() .
                '/Resources/views/' .
                'Wellbeing/UserState/background.jpg', 'r')
        );


        $imagick->scaleImage(150, 0);
        $imagick->setImageFormat("png");


        $entityManager = $this->get('entity_manager');
        $repositoryUserState = $entityManager->getRepository('Wellbeing\Bundle\ApiBundle\Entity\UserState');
        if (($userState = $repositoryUserState->find($unique))) {

            $width = $imagick->getImageWidth();
            $height = $imagick->getImageHeight();


            $projectionBuilder = new ProjectionBuilderXZ($width, $height, $userState);
//            $projectionBuilder->addPatcher(new ProjectionHeadShoulderPatcher())
//                ->addPatcher(new ProjectionSpineShoulderPatcher());

            $projection = new \Imagick();
            $projection->newImage($width, $height, new \ImagickPixel('transparent'));
            $projection->setImageFormat('png');
            $projection->drawImage($projectionBuilder->build());
            $projection->rotateImage(new \ImagickPixel(), 180);
            $projection->adaptiveResizeImage($width, $height, true);

            $imagick->setImageVirtualPixelMethod(\Imagick::VIRTUALPIXELMETHOD_TRANSPARENT);
            $imagick->compositeImage($projection, \Imagick::COMPOSITE_DEFAULT, 0, 0);
        }


        return new Response($imagick, 200, array(
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'inline; filename="state.png"'
        ));
    }

    /**
     * @param Request $request
     * @param null $unique
     * @return Response
     */
    public function stateYZAction(Request $request, $unique = null)
    {
        $imagick = new \Imagick();
        $imagick->setBackgroundColor(new \ImagickPixel('transparent'));
        $imagick->readImageFile(fopen($this->get('kernel')->getRootDir() .
                '/Resources/views/' .
                'Wellbeing/UserState/background.jpg', 'r')
        );


        $imagick->scaleImage(150, 0);
        $imagick->setImageFormat("png");


        $entityManager = $this->get('entity_manager');
        $repositoryUserState = $entityManager->getRepository('Wellbeing\Bundle\ApiBundle\Entity\UserState');
        if (($userState = $repositoryUserState->find($unique))) {

            $width = $imagick->getImageWidth();
            $height = $imagick->getImageHeight();


            $projectionBuilder = new ProjectionBuilderYZ($width, $height, $userState);
//            $projectionBuilder->addPatcher(new ProjectionHeadShoulderPatcher())
//                ->addPatcher(new ProjectionSpineShoulderPatcher());

            $projection = new \Imagick();
            $projection->newImage($width, $height, new \ImagickPixel('transparent'));
            $projection->setImageFormat('png');
            $projection->drawImage($projectionBuilder->build());
            $projection->rotateImage(new \ImagickPixel(), 180);
            $projection->adaptiveResizeImage($width, $height, true);

            $imagick->setImageVirtualPixelMethod(\Imagick::VIRTUALPIXELMETHOD_TRANSPARENT);
            $imagick->compositeImage($projection, \Imagick::COMPOSITE_DEFAULT, 0, 0);
        }


        return new Response($imagick, 200, array(
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'inline; filename="state.png"'
        ));
    }

    /**
     * Display last actual state of user
     * @param Request $request
     * @return Response
     */
    public function stateLiveAction(Request $request)
    {
        $entityManager = $this->get('entity_manager');
        $repositoryUserState = $entityManager->getRepository('Wellbeing\Bundle\ApiBundle\Entity\UserState');
        if (!(($userState = $repositoryUserState->findLast()))) {
            throw new \LogicException('User state object can not be empty');
        }

        if (!($media = $userState->getPreview1())) {
            throw new \LogicException('Media object can not be empty');
        }

        $provider = $this->container->get($media->getProviderName());

        $root = $this->get('kernel')->getRootDir();
        $path = $provider->generatePublicUrl($media, 'wellbeing_original');


        return new Response(file_get_contents("$root/../web$path"), 200, array(
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'inline; filename="state.png"'
        ));
    }

}