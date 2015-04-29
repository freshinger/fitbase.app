<?php

namespace Fitbase\Bundle\KnowledgeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PictureController extends Controller
{
    public function knowledgeAction(Request $request)
    {
        $imagick = new \Imagick();
        $imagick->setBackgroundColor(new \ImagickPixel('transparent'));
        $imagick->readImageBlob($this->renderView('Knowledge/Picture/Knowledge.html.twig', array()));
        $imagick->adaptiveResizeImage(718, 718);

        $imagick->setImageFormat("png");

        $rectangle = new \ImagickDraw();
        $rectangle->setFillColor(new \ImagickPixel('#ffffff'));
        $rectangle->rectangle(310, 20, 690, 680);
        $imagick->drawImage($rectangle);

        if (($knowledge = $this->get('knowledge')->current())) {

            $draw = new \ImagickDraw();
            $draw->setFont('Verdana');
            $draw->setFontSize(32);
            $draw->setFillColor(new \ImagickPixel('#000000'));
            $draw->setStrokeAntialias(true);
            $draw->setTextAntialias(true);
            $draw->annotation(330, 60, wordwrap($knowledge->getContent(), 21));
            $imagick->drawImage($draw);
        }

        if (($gamification = $this->get('gamification')->current())) {

            $date = $this->get('datetime')->getDateTime('now');
            if (($media = $gamification->getAvatarMedia($date))) {

                $root = $this->get('kernel')->getRootDir() . '/../web';
                $path = $this->container->get('sonata.media.twig.extension')->path($media, 'thumbnail');

                $imagick2 = new \Imagick();
                $imagick2->readImageBlob(\file_get_contents($root . $path));
                $imagick2->adaptiveResizeImage(300, 300);
                $imagick->setImageVirtualPixelMethod(\Imagick::VIRTUALPIXELMETHOD_TRANSPARENT);
                $imagick->compositeImage($imagick2, \Imagick::COMPOSITE_DEFAULT, 20, 238);
            }
        }

        $result = $imagick->mergeImageLayers(\Imagick::LAYERMETHOD_MERGE);
        $result->setImageFormat("png");

        return new Response($result->getImageBlob(), 200, array(
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'inline; filename="forest.png"'
        ));
    }
}
