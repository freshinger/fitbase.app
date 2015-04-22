<?php

namespace Fitbase\Bundle\GamificationBundle\Controller;

use Fitbase\Bundle\GamificationBundle\Entity\GamificationDialogQuestion;
use Fitbase\Bundle\GamificationBundle\Entity\GamificationUserDialogAnswer;
use Fitbase\Bundle\GamificationBundle\Entity\GamificationUserEmotion;
use Fitbase\Bundle\GamificationBundle\Event\GamificationUserDialogAnswerEvent;
use Fitbase\Bundle\GamificationBundle\Event\GamificationUserEmotionEvent;
use Fitbase\Bundle\GamificationBundle\Form\GamificationUserDialogAnswerBooleanForm;
use Fitbase\Bundle\GamificationBundle\Form\GamificationUserDialogAnswerFeedbackForm;
use Fitbase\Bundle\GamificationBundle\Form\GamificationUserDialogAnswerFinishForm;
use Fitbase\Bundle\GamificationBundle\Form\GamificationUserDialogAnswerForm;
use Fitbase\Bundle\GamificationBundle\Form\GamificationUserDialogAnswerNoticeForm;
use Fitbase\Bundle\GamificationBundle\Form\GamificationUserDialogAnswerTextForm;
use Fitbase\Bundle\GamificationBundle\Form\GamificationUserDialogAnswerTrashForm;
use Fitbase\Bundle\GamificationBundle\Form\GamificationUserEmotionForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PictureController extends Controller
{
    /**
     * Display user chat with avatar
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function avatarAction(Request $request)
    {
        $imagick = new \Imagick();
        $imagick->setBackgroundColor(new \ImagickPixel('transparent'));
        $imagick->readImageBlob($this->renderView('Gamification/Picture/Avatar.html.twig', array()));
        $imagick->scaleImage(360, 0);

        if (($gamification = $this->get('gamification')->current())) {

            $date = $this->get('datetime')->getDateTime('now');

            if (($media = $gamification->getAvatarMedia($date))) {

                $root = $this->get('kernel')->getRootDir() . '/../web';
                $path = $this->container->get('sonata.media.twig.extension')->path($media, 'icon');

                $imagick2 = new \Imagick();
                $imagick2->readImageBlob(\file_get_contents($root . $path));
                $imagick->setImageVirtualPixelMethod(\Imagick::VIRTUALPIXELMETHOD_TRANSPARENT);
                $imagick->compositeImage($imagick2, \Imagick::COMPOSITE_DEFAULT, 200, 73);
            }
        }


        if (($company = $this->get('company')->current())) {
            if (($gamification = $company->getGamification())) {

                $date = $this->get('datetime')->getDateTime('now');
                $points = $this->get('statistic')->points($this->get('user')->current());

                if (($media = $gamification->getTreeMedia($date, $points))) {

                    $root = $this->get('kernel')->getRootDir() . '/../web';
                    $path = $this->container->get('sonata.media.twig.extension')->path($media, 'icon');

                    $imagick2 = new \Imagick();
                    $imagick2->readImageBlob(\file_get_contents($root . $path));
                    $imagick->setImageVirtualPixelMethod(\Imagick::VIRTUALPIXELMETHOD_TRANSPARENT);
                    $imagick->compositeImage($imagick2, \Imagick::COMPOSITE_DEFAULT, 50, 44);
                }
            }
        }

        $result = $imagick->mergeImageLayers(\Imagick::LAYERMETHOD_MERGE);
        $result->setImageFormat("png");

        return new Response($result->getImageBlob(), 200, array(
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'inline; filename="avatar.png"'
        ));
    }

    /**
     * Display avatar preview
     * @param Request $request
     * @return Response
     */
    public function treeAction(Request $request)
    {
        $imagick = new \Imagick();
        $imagick->setBackgroundColor(new \ImagickPixel('transparent'));
        $imagick->readImageBlob($this->renderView('Gamification/Picture/Tree.html.twig', array()));
        $imagick->scaleImage(360, 0);
        $imagick->setImageFormat("png");

        if (($company = $this->get('company')->current())) {
            if (($gamification = $company->getGamification())) {

                $date = $this->get('datetime')->getDateTime('now');
                $points = $this->get('statistic')->points($this->get('user')->current());

                if (($media = $gamification->getTreeMedia($date, $points))) {

                    $root = $this->get('kernel')->getRootDir() . '/../web';
                    $path = $this->container->get('sonata.media.twig.extension')->path($media, 'icon');

                    $imagick2 = new \Imagick();
                    $imagick2->readImageBlob(\file_get_contents($root . $path));
                    $imagick->setImageVirtualPixelMethod(\Imagick::VIRTUALPIXELMETHOD_TRANSPARENT);
                    $imagick->compositeImage($imagick2, \Imagick::COMPOSITE_DEFAULT, 85, 63);
                }
            }
        }

        $result = $imagick->mergeImageLayers(\Imagick::LAYERMETHOD_MERGE);
        $result->setImageFormat("png");

        return new Response($result->getImageBlob(), 200, array(
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'inline; filename="tree.png"'
        ));
    }

    /**
     * Display company forest
     * @param Request $request
     * @return Response
     */
    public function forestAction(Request $request)
    {
        $imagick = new \Imagick();
        $imagick->setBackgroundColor(new \ImagickPixel('transparent'));
        $imagick->readImageBlob($this->renderView('Gamification/Picture/Forest.html.twig', array()));
        $imagick->scaleImage(360, 0);
        $imagick->setImageFormat("png");

        return new Response($imagick, 200, array(
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'inline; filename="forest.png"'
        ));
    }
}
