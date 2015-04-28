<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 27/04/15
 * Time: 10:54
 */

namespace Wellbeing\Bundle\ApiBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Wellbeing\Bundle\ApiBundle\Entity\UserState;
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


        $imagick->scaleImage(500, 0);
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

//            $draw = new \ImagickDraw();
//            $draw->setFillColor('#909090');
//            $draw->annotation(5, 15, "X,Y");
//            $draw->annotation(5 + $width / 2, 15, "Y, Z");
//            $draw->annotation(5, 15 + $height / 2, "X, Z");
//            $imagick->drawImage($draw);


            $xMax = $userState->getMaxXCoordinate();
            $xMin = $userState->getMinXCoordinate();

            $yMax = $userState->getMaxYCoordinate();
            $yMin = $userState->getMinYCoordinate();

            $zMax = $userState->getMaxZCoordinate();
            $zMin = $userState->getMinZCoordinate();


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
}