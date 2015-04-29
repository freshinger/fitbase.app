<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Controller;

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
use Symfony\Component\Validator\Constraints\Null;

class PictureController extends Controller
{
    /**
     * Display company forest
     * @param Request $request
     * @return Response
     */
    public function weeklytaskAction(Request $request, $unique)
    {
        $entityManager = $this->container->get('entity_manager');
        $repositoryWeeklytaskUser = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser');


        if (($user = $this->get('user')->current())) {
            if (($weeklytaskUser = $repositoryWeeklytaskUser->findOneByUserAndUnique($user, $unique))) {
                if (($weeklytask = $weeklytaskUser->getTask())) {

                    if (($content = $weeklytask->getContent())) {
                        \phpQuery::newDocumentHTML($content);

                        if (($images = pq('img'))) {
                            if (($image = (isset($images[0]) ? pq($images[0]) : null)) != null) {
                                if (($path = $this->patchSrc($image->attr('src')))) {

                                    $imagick2 = new \Imagick();
                                    $imagick2->readImageBlob(\file_get_contents($path));
                                    $imagick2->adaptiveResizeImage(718, 436);

                                    return new Response($imagick2, 200, array(
                                        'Content-Type' => 'image/png',
                                        'Content-Disposition' => 'inline; filename="forest.png"'
                                    ));
                                }
                            }
                        }

                        if (($categories = $weeklytask->getCategories())) {
                            if (($category = $categories->first())) {
                                if (($media = $category->getMedia())) {

                                    $root = $this->get('kernel')->getRootDir() . '/../web';
                                    $path = $this->container->get('sonata.media.twig.extension')->path($media, 'preview');

                                    $imagick2 = new \Imagick();
                                    $imagick2->readImageBlob(\file_get_contents($root . $path));
                                    $imagick2->adaptiveResizeImage(718, 436);

                                    return new Response($imagick2, 200, array(
                                        'Content-Type' => 'image/png',
                                        'Content-Disposition' => 'inline; filename="forest.png"'
                                    ));
                                }

                            }
                        }

                    }

                }
            }
        }

        $imagick = new \Imagick();
        $imagick->setBackgroundColor(new \ImagickPixel('transparent'));
        $imagick->readImageBlob($this->renderView('Gamification/Picture/Forest.html.twig', array()));
        $imagick->adaptiveResizeImage(718, 436);
        $imagick->setImageFormat("png");

        return new Response($imagick, 200, array(
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'inline; filename="forest.png"'
        ));
    }


    /**
     * Patch src to get a full link to download
     *
     * @param $user
     * @param $src
     * @return null
     */
    protected function patchSrc($src)
    {
        if (($parts = parse_url($src))) {
            if (!array_key_exists('scheme', $parts) and !array_key_exists('host', $parts)) {
                return $this->get('kernel')->getRootDir() . "/../web$src";

            }
        }

        return null;
    }
}
