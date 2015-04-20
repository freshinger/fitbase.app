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
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ReminderExerciseBlock extends BaseBlockService implements ContainerAwareInterface
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
            'template' => 'Reminder/Block/ReminderExercise.html.twig',
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
        if (($user = $this->container->get('user')->current())) {
            $entityManager = $this->container->get('entity_manager');
            $repositoryReminder = $entityManager->getRepository('Fitbase\Bundle\ReminderBundle\Entity\ReminderUser');
            $reminder = $repositoryReminder->findOneByUser($user);
        }

        $form = $this->container->get('form.factory')->create(new ReminderUserItemForm(), new ReminderUserItem());
        if ($this->container->get('request')->get($form->getName())) {
            $form->handleRequest($this->container->get('request'));
            if ($form->isValid()) {
                if (($entity = $form->getData())) {

                    $entity->setUser($user);
                    $entity->setType('exercise');
                    $entity->setReminder($reminder);

                    $event = new ReminderUserItemEvent($form->getData());
                    $this->container->get('event_dispatcher')->dispatch('reminder_item_create', $event);
                }
            }
        }

        if (($unique = $this->container->get('request')->get('uniqueitem'))) {
            $repositoryReminderItem = $entityManager->getRepository('Fitbase\Bundle\ReminderBundle\Entity\ReminderUserItem');
            if (($item = $repositoryReminderItem->findOneByUserAndId($user, $unique))) {

                $event = new ReminderUserItemEvent($item);
                $this->container->get('event_dispatcher')->dispatch('reminder_item_remove', $event);

                $event = new ReminderUserItemEvent($item);
                $this->container->get('event_dispatcher')->dispatch('reminder_item_removed', $event);
            }
        }


        $repositoryReminderItem = $entityManager->getRepository('Fitbase\Bundle\ReminderBundle\Entity\ReminderUserItem');
        $collection = $repositoryReminderItem->findAllByReminderAndType($reminder, 'exercise');

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
        return 'Remminder exercise (Form)';
    }
}