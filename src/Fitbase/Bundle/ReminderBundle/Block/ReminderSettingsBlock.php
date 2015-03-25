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

class ReminderSettingsBlock extends BaseBlockService implements ContainerAwareInterface
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
        $reminder = new ReminderUser();
        if (($user = $this->container->get('user')->current())) {

            $entityManager = $this->container->get('entity_manager');
            $repositoryReminder = $entityManager->getRepository('Fitbase\Bundle\ReminderBundle\Entity\ReminderUser');

            if (($reminder = $repositoryReminder->findOneByUser($user))) {
                if (($unique = $this->container->get('request')->get('stoppause'))) {

                    $reminder->setPause(false);
                    $reminder->setPauseStart(null);

                    $event = new ReminderUserEvent($reminder);
                    $this->container->get('event_dispatcher')->dispatch('reminder_update', $event);
                }
            }
        }

        $form = $this->container->get('form.factory')->create(new ReminderUserPauseForm(), $reminder);
        if ($this->container->get('request')->get($form->getName())) {
            $form->handleRequest($this->container->get('request'));
            if ($form->isValid()) {

                $reminder->setPauseStart($this->container->get('datetime')->getDateTime('now'));

                $event = new ReminderUserEvent($reminder);
                $this->container->get('event_dispatcher')->dispatch('reminder_update', $event);
            }
        }

        return $this->renderPrivateResponse('FitbaseReminderBundle:Block:reminder_settings.html.twig', array(
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