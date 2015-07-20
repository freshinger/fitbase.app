<?php

namespace Fitbase\Bundle\EmailBundle\Subscriber;


use Doctrine\Common\Collections\ArrayCollection;
use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseReminderEvent;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserEvent;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserReminderEvent;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskReminderEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ExerciseUserReminderSubscriber implements EventSubscriberInterface
{
    protected $mailer;
    protected $translator;
    protected $templating;
    protected $chooserCategory;
    protected $entityManager;


    public function __construct($mailer, $templating, $translator, $entityManager, $chooserCategory)
    {
        $this->mailer = $mailer;
        $this->translator = $translator;
        $this->templating = $templating;
        $this->chooserCategory = $chooserCategory;
        $this->entityManager = $entityManager;
    }

    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'fitbase.exercise_reminder_process' => array('onExerciseUserReminderProcessEvent'),
        );
    }

    /**
     *
     * @param ExerciseUserReminderEvent $event
     */
    public function onExerciseUserReminderProcessEvent(ExerciseUserReminderEvent $event)
    {
        if (!($exerciseUserReminder = $event->getEntity())) {
            throw new \LogicException('Exercise user reminder object can not be empty');
        }

        if (!($user = $exerciseUserReminder->getUser())) {
            throw new \LogicException('Exercise user object can not be empty');
        }

        $repository = $this->entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUserReminder');
        if (($exerciseUserReminderExisted = $repository->processed($exerciseUserReminder))) {
            throw new \LogicException('Reminder with this date was already sent');
        }

        $title = $this->translator->trans('Ihre fitbase Erinnerung');
        $content = $this->templating->render('Email/Subscriber/UserExercise.html.twig', array(
            'user' => $user,
            'company' => $user->getCompany(),
            'categoryFocus' => $this->getFocusCategoryMain($user),
            'categories' => $this->getFocusCategories($user),
        ));

        $this->mailer->mail($user, $title, $content);
    }

    /**
     * Get main focus category
     *
     * @param $user
     * @return null
     */
    protected function getFocusCategoryMain($user)
    {
        if (($focus = $user->getFocus())) {
            if (($categoryFocus = $focus->getFirstCategory())) {
                return $categoryFocus->getCategory();
            }
        }
        return NULL;
    }

    /**
     * @param $user
     * @return \Doctrine\Common\Collections\Collection|static
     */
    protected function getFocusCategories($user)
    {
        // TODO: refactor this crazy category chooser
        if ($user->getFocus() != null) {
            return (new ArrayCollection($this->chooserCategory->choose($user->getFocus())))
                ->filter(function ($element) {
                    return !$element->getParent() ? true : false;
                });
        }
    }


}