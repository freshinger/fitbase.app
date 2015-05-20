<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\UserBundle\Block;

use Fitbase\Bundle\ReminderBundle\Entity\ReminderUser;
use Fitbase\Bundle\ReminderBundle\Entity\ReminderUserItem;
use Fitbase\Bundle\ReminderBundle\Event\ReminderUserEvent;
use Fitbase\Bundle\ReminderBundle\Event\ReminderUserItemEvent;
use Fitbase\Bundle\ReminderBundle\Form\ReminderUserForm;
use Fitbase\Bundle\ReminderBundle\Form\ReminderUserItemForm;
use Fitbase\Bundle\ReminderBundle\Form\ReminderUserPauseForm;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Fitbase\Bundle\UserBundle\Event\UserFocusEvent;
use Fitbase\Bundle\UserBundle\Form\UserFocusPriorityForm;
use Fitbase\Bundle\UserBundle\Form\UserRecoverForm;
use Fitbase\Bundle\UserBundle\Form\UserRemoveForm;
use Fitbase\Bundle\UserBundle\Model\UserRemove;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AccountRemoveBlock extends BaseBlockService implements ContainerAwareInterface
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
     * @return array
     */
    protected function getRole()
    {
        return array(
            'ROLE_FITBASE_USER'
        );
    }

    /**
     * Define
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'template_remove' => 'User/Block/AccountRemove.html.twig',
            'template_recover' => 'User/Block/AccountRecover.html.twig',
        ));
    }

    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        if (!($user = $this->container->get('user')->current())) {
            throw new \LogicException('User object can not be empty');
        }

        if ($user->getRemoveRequest()) {
            return $this->executeRecover($user, $blockContext, $response);
        }

        return $this->executeRemove($user, $blockContext, $response);
    }

    /**
     *
     * @param UserInterface $user
     * @param BlockContextInterface $blockContext
     * @param Response $response
     * @return Response
     */
    protected function executeRecover(UserInterface $user, BlockContextInterface $blockContext, Response $response = null)
    {
        $form = $this->container->get('form.factory')->create(new UserRecoverForm(), new UserRemove());
        if ($this->container->get('request')->get($form->getName())) {
            $form->handleRequest($this->container->get('request'));
            if ($form->isValid()) {

                $this->container->get('event_dispatcher')->dispatch(
                    'fitbase.user_remove_recover', new UserEvent($user));

                return $this->executeRemove($user, $blockContext, $response);
            }
        }

        return $this->renderResponse($blockContext->getSetting('template_recover'), array(
            'form' => $form->createView()
        ));
    }


    /**
     * Display remove form
     * @param UserInterface $user
     * @param BlockContextInterface $blockContext
     * @param Response $response
     * @return Response
     */
    protected function executeRemove(UserInterface $user, BlockContextInterface $blockContext, Response $response = null)
    {
        $form = $this->container->get('form.factory')->create(new UserRemoveForm(), new UserRemove());
        if ($this->container->get('request')->get($form->getName())) {
            $form->handleRequest($this->container->get('request'));
            if ($form->isValid()) {

                $this->container->get('event_dispatcher')->dispatch(
                    'fitbase.user_remove_prepare', new UserEvent($user));

                return $this->executeRecover($user, $blockContext, $response);
            }
        }

        return $this->renderResponse($blockContext->getSetting('template_remove'), array(
            'form' => $form->createView()
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Remove user account (Profile)';
    }
} 