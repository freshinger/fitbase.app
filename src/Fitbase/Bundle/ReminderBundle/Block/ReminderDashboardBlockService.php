<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\ReminderBundle\Block;


use Fitbase\Bundle\ReminderBundle\Entity\ReminderUser;
use Fitbase\Bundle\ReminderBundle\Entity\ReminderUserItem;
use Fitbase\Bundle\ReminderBundle\Event\ReminderUserEvent;
use Fitbase\Bundle\ReminderBundle\Event\ReminderUserItemEvent;
use Fitbase\Bundle\ReminderBundle\Form\ReminderUserForm;
use Fitbase\Bundle\ReminderBundle\Form\ReminderUserItemForm;
use Fitbase\Bundle\ReminderBundle\Form\ReminderUserPauseForm;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ReminderDashboardBlockService extends BaseBlockService implements ContainerAwareInterface
{
    /**
     * Store container here
     * @var
     */
    protected $container;

    /**
     * Set container
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $entityManager = $this->container->get('entity_manager');
        $repositoryReminder = $entityManager->getRepository('Fitbase\Bundle\ReminderBundle\Entity\ReminderUser');
        $repositoryReminderItem = $entityManager->getRepository('Fitbase\Bundle\ReminderBundle\Entity\ReminderUserItem');

        $collection = array();
        $reminder = new ReminderUser();
        $reminderItem = new ReminderUserItem();

        if (($user = $this->container->get('user')->current())) {
            $reminderItem->setUser($user);

            if (!($reminder = $repositoryReminder->findOneByUser($user))) {

                $reminder = new ReminderUser();
                $reminder->setUser($user);
                $reminder->setPause(false);
                $reminder->setSendWeeklyquiz(true);
                $reminder->setSendWeeklytask(true);

                $event = new ReminderUserEvent($reminder);
                $this->container->get('event_dispatcher')->dispatch('reminder_create', $event);
            }


            if (($unique = $this->container->get('request')->get('stoppause'))) {

                $reminder->setPause(false);
                $reminder->setPauseStart(null);

                $event = new ReminderUserEvent($reminder);
                $this->container->get('event_dispatcher')->dispatch('reminder_update', $event);
            }


            if (($unique = $this->container->get('request')->get('uniqueitem'))) {

                if (($item = $repositoryReminderItem->findOneByUserAndId($user, $unique))) {

                    $event = new ReminderUserItemEvent($item);
                    $this->container->get('event_dispatcher')->dispatch('reminder_item_remove', $event);

                    $event = new ReminderUserItemEvent($item);
                    $this->container->get('event_dispatcher')->dispatch('reminder_item_removed', $event);
                }
            }

            $reminderItem->setReminder($reminder);
            $collection = $repositoryReminderItem->findAllByReminder($reminder);
        }


        $form = $this->container->get('form.factory')->create(new ReminderUserItemForm(), $reminderItem);
        if ($this->container->get('request')->get($form->getName())) {
            $form->handleRequest($this->container->get('request'));
            if ($form->isValid()) {

                $event = new ReminderUserItemEvent($reminderItem);
                $this->container->get('event_dispatcher')->dispatch('reminder_item_create', $event);

//                $request = $this->container->get('request');
//                return new RedirectResponse($this->container->get('router')->generate($request->get('_route')));
            }
        }

        $formReminder = $this->container->get('form.factory')->create(new ReminderUserForm(), $reminder);
        if ($this->container->get('request')->get($formReminder->getName())) {
            $formReminder->handleRequest($this->container->get('request'));
            if ($formReminder->isValid()) {

                $event = new ReminderUserEvent($reminder);
                $this->container->get('event_dispatcher')->dispatch('reminder_update', $event);

//                $request = $this->container->get('request');
//                return new RedirectResponse($this->container->get('router')->generate($request->get('_route')));
            }
        }

        $formReminderPause = $this->container->get('form.factory')->create(new ReminderUserPauseForm(), $reminder);
        if ($this->container->get('request')->get($formReminderPause->getName())) {
            $formReminderPause->handleRequest($this->container->get('request'));
            if ($formReminderPause->isValid()) {

                $reminder->setPauseStart($this->container->get('datetime')->getDateTime('now'));

//                $event = new ReminderUserEvent($reminder);
//                $this->container->get('event_dispatcher')->dispatch('reminder_update', $event);
            }
        }

        return $this->renderPrivateResponse('FitbaseReminderBundle:Block:dashboard.html.twig', array(
            'items' => $collection,
            'reminder' => $reminder,
            'formReminder' => $formReminder->createView(),
            'formReminderItem' => $form->createView(),
            'formReminderPause' => $formReminderPause->createView(),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Dashboard (Reminder)';
    }
}