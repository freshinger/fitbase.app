<?php

namespace Fitbase\Bundle\UserBundle\Controller;

use Fitbase\Bundle\UserBundle\Builder\BuilderMentee;
use Fitbase\Bundle\UserBundle\Entity\UserMedimouse;
use Fitbase\Bundle\UserBundle\Event\UserMedimouseEvent;
use Fitbase\Bundle\UserBundle\Form\MenteeForm;
use Fitbase\Bundle\UserBundle\Entity\Mentee;
use Fitbase\Bundle\UserBundle\Event\MenteeEvent;
use Fitbase\Bundle\UserBundle\Facade\FacadeUserMentee;
use Fitbase\Bundle\UserBundle\Form\UserMedimouseForm;
use Fitbase\Bundle\WordpressBundle\Controller\WordpressControllerAbstract;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ExerciseController extends WordpressControllerAbstract
{
    public function exerciseAction()
    {
        if (($id = $this->container->get('fitbase_wordpress.api')->getPostIdCurrent())) {
            if (($post = $this->container->get('ekino.wordpress.manager.user_meta')->find($id))) {

                if ($this->get('request')->get('fallback')) {

                    return $this->render('FitbaseUserBundle:Exercise:exercise_image.html.twig', array(
                        'post' => $post,
                    ));

                } else {

                    return $this->render('FitbaseUserBundle:Exercise:exercise_video.html.twig', array(
                        'post' => $post,
                    ));
                }
            }
        }
    }
}
