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

        if (($gamification = $this->get('gamification')->current())) {

            $date = $this->get('datetime')->getDateTime('now');

            if (($media = $gamification->getAvatarMedia($date))) {

                $root = $this->get('kernel')->getRootDir() . '/../web';
                $path = $this->container->get('sonata.media.twig.extension')->path($media, 'preview');

                $imagick2 = new \Imagick();
                $imagick2->readImageBlob(\file_get_contents($root . $path));
                $imagick2->adaptiveResizeImage(250, 250);

                $imagick->setImageVirtualPixelMethod(\Imagick::VIRTUALPIXELMETHOD_TRANSPARENT);

                $imagick->compositeImage($imagick2, \Imagick::COMPOSITE_DEFAULT, 60, 391);
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
