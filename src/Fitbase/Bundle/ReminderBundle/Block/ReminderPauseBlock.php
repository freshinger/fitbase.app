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

class ReminderPauseBlock extends BaseBlockService implements ContainerAwareInterface
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
     * Set defaults
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'template' => 'Reminder/Block/ReminderPause.html.twig',
        ));
    }

    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $request = $this->container->get('request');
        $datetime = $this->container->get('datetime');
        $translator = $this->container->get('translator');
        $formFactory = $this->container->get('form.factory');
        $eventDispatcher = $this->container->get('event_dispatcher');
        $entityManager = $this->container->get('entity_manager');
        $repositoryReminder = $entityManager->getRepository('Fitbase\Bundle\ReminderBundle\Entity\ReminderUser');

        if (!($user = $this->container->get('user')->current())) {
            throw new \LogicException('User object can not be empty');
        }

        $reminder = new ReminderUser();
        if (($reminder = $repositoryReminder->findOneByUser($user))) {
            if (($unique = $request->get('stoppause'))) {

                $reminder->setPause(false);
                $reminder->setPauseStart(null);

                $event = new ReminderUserEvent($reminder);
                $eventDispatcher->dispatch('reminder_update', $event);
            }
        }

        $form = $formFactory->create(new ReminderUserPauseForm($translator), $reminder);
        if ($request->get($form->getName())) {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $reminder->setPauseStart($datetime->getDateTime('now'));

                $event = new ReminderUserEvent($reminder);
                $eventDispatcher->dispatch('reminder_update', $event);
            }
        }

        return $this->renderPrivateResponse($blockContext->getSetting('template'), array(
            'reminder' => $reminder,
            'form' => $form->createView(),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Reminder pause (Form)';
    }
}