<?php

namespace Fitbase\Bundle\EmailBundle\Subscriber;


use Doctrine\Common\Collections\ArrayCollection;
use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseReminderEvent;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskReminderEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ExerciseUserSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'exercise_reminder_send' => array('onExerciseUserSendEvent'),
        );
    }

    /**
     *
     * @param ExerciseUserEvent $event
     */
    public function onExerciseUserSendEvent(ExerciseUserEvent $event)
    {
        if (($exerciseUser = $event->getEntity())) {
            if (($user = $exerciseUser->getUser())) {

                $category = null;
                if (($focus = $user->getFocus())) {
                    if (($categoryFocus = $focus->getCategories()->first())) {
                        $categoryFocus = $categoryFocus->getCategory();
                    }
                }

                $categories = array();
                if (($chooserCategory = $this->container->get('chooser_category'))) {
                    $categories = new ArrayCollection(
                        $chooserCategory->choose($user->getFocus())
                    );


                    $categories = $categories->filter(function ($element) {
                        return !$element->getParent() ? true : false;
                    });
                }

                $title = $this->container->get('translator')->trans('Ihre fitbase Erinnerung');
                $content = $this->container->get('templating')->render('FitbaseEmailBundle:Subscriber:exercise.html.twig', array(
                    'user' => $exerciseUser->getUser(),
                    'categoryFocus' => $categoryFocus,
                    'categories' => $categories,
                    'exerciseUser' => $exerciseUser,
                ));

                $this->container->get('mail')->mail($user->getEmail(), $title, $content);
            }

            $exerciseUser->setProcessed(1);
            $this->container->get('entity_manager')->persist($exerciseUser);
            $this->container->get('entity_manager')->flush($exerciseUser);
        }
    }
}