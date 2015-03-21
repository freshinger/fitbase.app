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

class ExerciseUserSubscriber implements EventSubscriberInterface
{
    protected $mailer;
    protected $translator;
    protected $templating;
    protected $chooserCategory;
    protected $objectManager;


    public function __construct($mailer, $templating, $translator, $objectManager, $chooserCategory)
    {
        $this->mailer = $mailer;
        $this->translator = $translator;
        $this->templating = $templating;
        $this->chooserCategory = $chooserCategory;
        $this->objectManager = $objectManager;
    }

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
        if (($exerciseUser = $event->getEntity()) and ($user = $exerciseUser->getUser())) {

            $category = null;
            if (($focus = $user->getFocus())) {
                if (($categoryFocus = $focus->getFirstCategory())) {
                    $categoryFocus = $categoryFocus->getCategory();
                }
            }

            $categories = (new ArrayCollection($this->chooserCategory->choose($user->getFocus())))
                ->filter(function ($element) {
                    return !$element->getParent() ? true : false;
                });

            $title = $this->translator->trans('Ihre fitbase Erinnerung');
            $content = $this->templating->render('FitbaseEmailBundle:Subscriber:exercise.html.twig', array(
                'user' => $exerciseUser->getUser(),
                'categoryFocus' => $categoryFocus,
                'categories' => $categories,
                'exerciseUser' => $exerciseUser,
            ));

            $this->mailer->mail($user, $title, $content);
        }

        $exerciseUser->setProcessed(1);
        $this->objectManager->persist($exerciseUser);
        $this->objectManager->flush($exerciseUser);
    }
}