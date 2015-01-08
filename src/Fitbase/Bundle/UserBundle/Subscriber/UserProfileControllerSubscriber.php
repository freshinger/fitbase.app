<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 10/11/14
 * Time: 13:58
 */

namespace Fitbase\Bundle\UserBundle\Subscriber;

use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser;
use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserAnswer;
use Fitbase\Bundle\QuestionnaireBundle\Event\QuestionnaireUserAnswerEvent;
use Fitbase\Bundle\QuestionnaireBundle\Event\QuestionnaireUserEvent;
use Fitbase\Bundle\QuestionnaireBundle\Form\Constraint\QuestionnaireQuestionConstraint;
use Fitbase\Bundle\QuestionnaireBundle\Form\QuestionnaireUserForm;
use Fitbase\Bundle\UserBundle\Form\UserFocusPriorityForm;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class UserProfileControllerSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'questionnaire_step_1' => array('onQuestionnaireStep1', -128),
        );
    }

    public function onQuestionnaireStep1(FilterResponseEvent $event)
    {
        if (!($user = $this->container->get('user')->current())) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        if (($focus = $user->getFocus())) {

            $form = $this->container->get('form.factory')->create(new UserFocusPriorityForm($user), $focus);
            if ($event->getRequest()->get($form->getName())) {
                $form->handleRequest($event->getRequest());
                if ($form->isValid()) {

                    foreach ($focus->getCategories() as $category) {
                        $this->container->get('entity_manager')->persist($category);
                        $this->container->get('entity_manager')->flush($category);
                    }

                    $event->getRequest()->getSession()->getFlashBag()->add('success',
                        'Ihr Fokus wurde geschpeichert.'
                    );

                    $this->container->get('entity_manager')->refresh($focus);
                    return null;
                }
            }

            $event->setResponse(
                $this->container->get('templating')->renderResponse('FitbaseUserBundle:Subscriber:focus.html.twig', array(
                    'user' => $user,
                    'form' => $form->createView(),
                ))
            );

        }

        return null;
    }
}