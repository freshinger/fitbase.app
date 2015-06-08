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
use Symfony\Component\HttpFoundation\StreamedResponse;
use Wellbeing\Bundle\ApiBundle\Imagick\Patcher\ProjectionHeadShoulderPatcher;
use Wellbeing\Bundle\ApiBundle\Imagick\Patcher\ProjectionShoulderLeftSpinePatcher;
use Wellbeing\Bundle\ApiBundle\Imagick\Patcher\ProjectionShoulderRightSpinePatcher;
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


        $entityManager = $this->get('entity_manager');
        $repositoryUserState = $entityManager->getRepository('Wellbeing\Bundle\ApiBundle\Entity\UserState');
        if (!(($userState = $repositoryUserState->findLast()))) {
            throw new \LogicException('User state object can not be empty');
        }


        $width = $imagick->getImageWidth();
        $height = $imagick->getImageHeight();

        $projectionBuilder = (new ProjectionBuilderXY($width, $height, $userState, false))
            ->addPatcher((new ProjectionShoulderLeftSpinePatcher())
                ->setGetX(function (\Wellbeing\Bundle\ApiBundle\Entity\UserState $userState) {
                    return [
                        $userState->getShoulderCenter()->getX(),
                        $userState->getShoulderLeft()->getX(),
                        $userState->getSpine()->getX(),
                    ];
                })->setGetY(function (\Wellbeing\Bundle\ApiBundle\Entity\UserState $userState) {
                    return [
                        $userState->getShoulderCenter()->getY(),
                        $userState->getShoulderLeft()->getY(),
                        $userState->getSpine()->getY(),
                    ];
                }))
            ->addPatcher((new ProjectionShoulderRightSpinePatcher())
                ->setGetX(function (\Wellbeing\Bundle\ApiBundle\Entity\UserState $userState) {
                    return [
                        $userState->getShoulderCenter()->getX(),
                        $userState->getShoulderRight()->getX(),
                        $userState->getSpine()->getX(),
                    ];
                })->setGetY(function (\Wellbeing\Bundle\ApiBundle\Entity\UserState $userState) {
                    return [
                        $userState->getShoulderCenter()->getY(),
                        $userState->getShoulderRight()->getY(),
                        $userState->getSpine()->getY(),
                    ];
                }))
            ->addPatcher((new ProjectionHeadShoulderPatcher())
                ->setGetX(function (\Wellbeing\Bundle\ApiBundle\Entity\UserState $userState) {
                    return [
                        $userState->getShoulderCenter()->getX(),
                        $userState->getShoulderLeft()->getX(),
                        $userState->getShoulderRight()->getX(),
                    ];
                })->setGetY(function (\Wellbeing\Bundle\ApiBundle\Entity\UserState $userState) {
                    return [
                        $userState->getShoulderCenter()->getY(),
                        $userState->getShoulderLeft()->getY(),
                        $userState->getShoulderRight()->getY(),
                    ];
                }));

        $projection = new \Imagick();
        $projection->newImage($width, $height, new \ImagickPixel('transparent'));
        $projection->setImageFormat('png');
        $projection->drawImage($projectionBuilder->build());
        $projection->rotateImage(new \ImagickPixel(), 180);
        $projection->adaptiveResizeImage($width, $height, true);

        $imagick->setImageVirtualPixelMethod(\Imagick::VIRTUALPIXELMETHOD_TRANSPARENT);
        $imagick->compositeImage($projection, \Imagick::COMPOSITE_DEFAULT, 0, 0);


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

// Used to separate multipart
        $boundary = "spiderman";
// We start with the standard headers. PHP allows us this much
        header("Cache-Control: no-cache");
        header("Cache-Control: private");
        header("Pragma: no-cache");
        header("Content-type: multipart/x-mixed-replace; boundary=$boundary");
// Set this so PHP doesn't timeout during a long stream
        set_time_limit(0);
        $rand = rand(1, 10000);
        $i = rand(1, 10000);
        while (true) {
            $i++;


            // Per-image header, note the two new-lines
//            $im = imagecreatetruecolor(400, 400);
//            $fill_color = imagecolorallocate($im, (128 * sin($i / 30)) + 128, (128 * sin($i / 25)) + 128, (128 * sin($i / 20)) + 128);
//            imagefill($im, 1, 1, $fill_color);
//            $text_color = imagecolorallocate($im, 255, 255, 255);
//            imagestring($im, 7, 5, 5, $rand . ' || ' . date('c'), $text_color);


//            ob_start();

            $imagick = new \Imagick();
            $imagick->newImage(400, 400, new \ImagickPixel('white'));
            $imagick->setImageFormat("jpeg");
            $imagick->setImageCompressionQuality(90);
            $imagick->readImageFile(fopen($this->get('kernel')->getRootDir() .
                    '/Resources/views/' .
                    'Wellbeing/UserState/background.jpg', 'r')
            );


            $repositoryUserState = $entityManager->getRepository('Wellbeing\Bundle\ApiBundle\Entity\UserState');
            if (!(($userState = $repositoryUserState->findLast()))) {
                throw new \LogicException('User state object can not be empty');
            }


            $width = $imagick->getImageWidth();
            $height = $imagick->getImageHeight();

            $projectionBuilder = (new ProjectionBuilderXY($width, $height, $userState, false))
                ->addPatcher((new ProjectionShoulderLeftSpinePatcher())
                    ->setGetX(function (\Wellbeing\Bundle\ApiBundle\Entity\UserState $userState) {
                        return [
                            $userState->getShoulderCenter()->getX(),
                            $userState->getShoulderLeft()->getX(),
                            $userState->getSpine()->getX(),
                        ];
                    })->setGetY(function (\Wellbeing\Bundle\ApiBundle\Entity\UserState $userState) {
                        return [
                            $userState->getShoulderCenter()->getY(),
                            $userState->getShoulderLeft()->getY(),
                            $userState->getSpine()->getY(),
                        ];
                    }))
                ->addPatcher((new ProjectionShoulderRightSpinePatcher())
                    ->setGetX(function (\Wellbeing\Bundle\ApiBundle\Entity\UserState $userState) {
                        return [
                            $userState->getShoulderCenter()->getX(),
                            $userState->getShoulderRight()->getX(),
                            $userState->getSpine()->getX(),
                        ];
                    })->setGetY(function (\Wellbeing\Bundle\ApiBundle\Entity\UserState $userState) {
                        return [
                            $userState->getShoulderCenter()->getY(),
                            $userState->getShoulderRight()->getY(),
                            $userState->getSpine()->getY(),
                        ];
                    }))
                ->addPatcher((new ProjectionHeadShoulderPatcher())
                    ->setGetX(function (\Wellbeing\Bundle\ApiBundle\Entity\UserState $userState) {
                        return [
                            $userState->getShoulderCenter()->getX(),
                            $userState->getShoulderLeft()->getX(),
                            $userState->getShoulderRight()->getX(),
                        ];
                    })->setGetY(function (\Wellbeing\Bundle\ApiBundle\Entity\UserState $userState) {
                        return [
                            $userState->getShoulderCenter()->getY(),
                            $userState->getShoulderLeft()->getY(),
                            $userState->getShoulderRight()->getY(),
                        ];
                    }));

            $projection = new \Imagick();
            $projection->newImage($width, $height, new \ImagickPixel('transparent'));
            $projection->setImageFormat('png');
            $projection->drawImage($projectionBuilder->build());
            $projection->rotateImage(new \ImagickPixel(), 180);
            $projection->adaptiveResizeImage($width, $height, true);

            $imagick->setImageVirtualPixelMethod(\Imagick::VIRTUALPIXELMETHOD_TRANSPARENT);
            $imagick->compositeImage($projection, \Imagick::COMPOSITE_DEFAULT, 0, 0);


            echo $imagick->getImageBlob();
            $imagick->destroy();

            usleep(300);
            echo "--$boundary\n";
            echo "Content-type: image/jpeg\n\n";
        }
    }

}