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
        $imagick->readImageBlob($this->renderView('FitbaseKnowledgeBundle:Picture:Knowledge.html.twig', array()));
        $imagick->scaleImage(270, 0);
        $imagick->setImageFormat("png");

        $rectangle = new \ImagickDraw();
        $rectangle->setFillColor(new \ImagickPixel('#ffffff'));
        $rectangle->rectangle(5, 15, 250, 150);
        $imagick->drawImage($rectangle);

        if (($knowledge = $this->get('knowledge')->current())) {

            $draw = new \ImagickDraw();
            $draw->setFont('Verdana');
            $draw->setFontSize(12);
            $draw->setFillColor(new \ImagickPixel('#000000'));
            $draw->setStrokeAntialias(true);
            $draw->setTextAntialias(true);
            $draw->annotation(10, 30, wordwrap($knowledge->getContent(), 37));
            $imagick->drawImage($draw);
        }

        if (($gamification = $this->get('gamification')->current())) {

            $date = $this->get('datetime')->getDateTime('now');
            if (($media = $gamification->getAvatarMedia($date))) {

                $root = $this->get('kernel')->getRootDir() . '/../web';
                $path = $this->container->get('sonata.media.twig.extension')->path($media, 'icon');

                $imagick2 = new \Imagick();
                $imagick2->readImageBlob(\file_get_contents($root . $path));
                $imagick->setImageVirtualPixelMethod(\Imagick::VIRTUALPIXELMETHOD_TRANSPARENT);
                $imagick->compositeImage($imagick2, \Imagick::COMPOSITE_DEFAULT, 30, 133);
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
