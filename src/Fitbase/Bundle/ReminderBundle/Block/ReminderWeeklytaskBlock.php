<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\ReminderBundle\Block;


use Fitbase\Bundle\ReminderBundle\Entity\ReminderUserItem;
use Fitbase\Bundle\ReminderBundle\Event\ReminderUserItemEvent;
use Fitbase\Bundle\ReminderBundle\Form\ReminderUserForm;
use Fitbase\Bundle\ReminderBundle\Form\ReminderUserItemForm;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ReminderWeeklytaskBlock extends BaseBlockService implements ContainerAwareInterface
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
            'template' => 'Reminder/Block/ReminderWeeklytask.html.twig',
        ));
    }


    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $user = null;
        $reminder = null;
        $entityManager = $this->container->get('entity_manager');
        $repositoryReminder = $entityManager->getRepository('Fitbase\Bundle\ReminderBundle\Entity\ReminderUser');
        $formFactory = $this->container->get('form.factory');
        $translator = $this->container->get('translator');
        $request = $this->container->get('request');
        $eventDispatcher = $this->container->get('event_dispatcher');

        if (($user = $this->container->get('user')->current())) {
            $reminder = $repositoryReminder->findOneByUser($user);
        }

        $form = $formFactory->create(new ReminderUserItemForm('weeklytask_reminder_item', $translator), new ReminderUserItem());

        if ($request->get($form->getName())) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                if (($entity = $form->getData())) {

                    $entity->setUser($user);
                    $entity->setType('weeklytask');
                    $entity->setReminder($reminder);

                    $event = new ReminderUserItemEvent($form->getData());
                    $eventDispatcher->dispatch('reminder_item_create', $event);
                }
            }
        }

        if (($unique = $request->get('uniqueitem'))) {
            $repositoryReminderItem = $entityManager->getRepository('Fitbase\Bundle\ReminderBundle\Entity\ReminderUserItem');
            if (($item = $repositoryReminderItem->findOneByUserAndId($user, $unique))) {

                $event = new ReminderUserItemEvent($item);
                $eventDispatcher->dispatch('reminder_item_remove', $event);

                $event = new ReminderUserItemEvent($item);
                $eventDispatcher->dispatch('reminder_item_removed', $event);
            }
        }

        $repositoryReminderItem = $entityManager->getRepository('Fitbase\Bundle\ReminderBundle\Entity\ReminderUserItem');
        $collection = $repositoryReminderItem->findAllByReminderAndType($reminder, 'weeklytask');

        return $this->renderPrivateResponse($blockContext->getSetting('template'), array(
            'form' => $form->createView(),
            'collection' => $collection,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Reminder weeklytask (Form)';
    }
}