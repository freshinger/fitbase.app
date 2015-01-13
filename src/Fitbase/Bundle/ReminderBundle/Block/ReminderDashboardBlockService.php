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
use Fitbase\Bundle\ReminderBundle\Form\ReminderUserItemWeeklytaskForm;
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
use Symfony\Component\HttpFoundation\Request;
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
            $collection = $repositoryReminderItem->findAllByReminderAndType($reminder, 'exercise');
            $collectionWeeklytask = $repositoryReminderItem->findAllByReminderAndType($reminderItem->getReminder(), 'weeklytask');

        }

        $formReminderItem = $this->renderReminderUserItemForm($this->container->get('request'), $reminderItem, function ($reminderItem) use (&$collection) {
            $entityManager = $this->container->get('entity_manager');
            $repositoryReminderItem = $entityManager->getRepository('Fitbase\Bundle\ReminderBundle\Entity\ReminderUserItem');
            $collection = $repositoryReminderItem->findAllByReminderAndType($reminderItem->getReminder(), 'exercise');
        });


        $formReminderItemWeeklytask = $this->renderReminderUserItemWeeklytaskForm($this->container->get('request'), $reminderItem, function ($reminderItem) use (&$collectionWeeklytask) {
            $entityManager = $this->container->get('entity_manager');
            $repositoryReminderItem = $entityManager->getRepository('Fitbase\Bundle\ReminderBundle\Entity\ReminderUserItem');
            $collectionWeeklytask = $repositoryReminderItem->findAllByReminderAndType($reminderItem->getReminder(), 'weeklytask');
        });


        $formReminderPause = $this->renderReminderUserPauseForm($this->container->get('request'), $reminder);

        return $this->renderPrivateResponse('FitbaseReminderBundle:Block:dashboard.html.twig', array(
            'items' => $collection,
            'itemsWeeklytask' => $collectionWeeklytask,
            'reminder' => $reminder,
            'formReminderItem' => $formReminderItem->createView(),
            'formReminderItemWeeklytask' => $formReminderItemWeeklytask->createView(),
            'formReminderPause' => $formReminderPause->createView(),
        ));
    }

    /**
     * Render reminder and process item form
     * @param $request
     * @param $reminderItem
     * @param null $callback
     * @return mixed
     */
    protected function renderReminderUserItemWeeklytaskForm(Request $request, $reminderItem, $callback = null)
    {
        $formReminderItem = $this->container->get('form.factory')->create(new ReminderUserItemWeeklytaskForm(), $reminderItem);
        if ($this->container->get('request')->get($formReminderItem->getName())) {
            $reminderItem->setType('weeklytask');
            $formReminderItem->handleRequest($this->container->get('request'));
            if ($formReminderItem->isValid()) {
                $event = new ReminderUserItemEvent($reminderItem);
                $this->container->get('event_dispatcher')->dispatch('reminder_item_create', $event);

                if ($callback instanceof \Closure) {
                    $callback ($reminderItem);
                }
            }
        }
        return $formReminderItem;
    }

    /**
     * Render reminder and process item form
     * @param $request
     * @param $reminderItem
     * @param null $callback
     * @return mixed
     */
    protected function renderReminderUserItemForm(Request $request, $reminderItem, $callback = null)
    {
        $formReminderItem = $this->container->get('form.factory')->create(new ReminderUserItemForm(), $reminderItem);
        if ($this->container->get('request')->get($formReminderItem->getName())) {
            $reminderItem->setType('exercise');
            $formReminderItem->handleRequest($this->container->get('request'));
            if ($formReminderItem->isValid()) {
                $event = new ReminderUserItemEvent($reminderItem);
                $this->container->get('event_dispatcher')->dispatch('reminder_item_create', $event);

                if ($callback instanceof \Closure) {
                    $callback ($reminderItem);
                }
            }
        }
        return $formReminderItem;
    }


    /**
     * Render and process reminder user form
     * @param $request
     * @param $reminder
     * @return mixed
     */
    protected function renderReminderUserForm(Request $request, ReminderUser $entity, $callback = null)
    {
        $formReminder = $this->container->get('form.factory')->create(new ReminderUserForm(), $entity);
        if ($this->container->get('request')->get($formReminder->getName())) {
            $formReminder->handleRequest($this->container->get('request'));
            if ($formReminder->isValid()) {

                $event = new ReminderUserEvent($entity);
                $this->container->get('event_dispatcher')->dispatch('reminder_update', $event);

                if ($callback instanceof \Closure) {
                    $callback ($entity);
                }
            }
        }

        return $formReminder;
    }

    /**
     * Render and process reminder pause form
     * @param $request
     * @param $reminder
     */
    protected function renderReminderUserPauseForm(Request $request, ReminderUser $entity, $callback = null)
    {
        $formReminderPause = $this->container->get('form.factory')->create(new ReminderUserPauseForm(), $entity);
        if ($this->container->get('request')->get($formReminderPause->getName())) {
            $formReminderPause->handleRequest($this->container->get('request'));
            if ($formReminderPause->isValid()) {

                $entity->setPauseStart($this->container->get('datetime')->getDateTime('now'));

                $event = new ReminderUserEvent($entity);
                $this->container->get('event_dispatcher')->dispatch('reminder_update', $event);

                if ($callback instanceof \Closure) {
                    $callback ($entity);
                }
            }
        }
        return $formReminderPause;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Dashboard (Reminder)';
    }
}