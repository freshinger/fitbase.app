<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\UserBundle\Block;

use Fitbase\Bundle\FitbaseBundle\Library\Block\BaseFitbaseBlock;
use Fitbase\Bundle\ReminderBundle\Form\ReminderUserForm;
use Fitbase\Bundle\UserBundle\Event\UserFocusEvent;
use Fitbase\Bundle\UserBundle\Form\UserFocusPriorityForm;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserProfileFocusBlock extends BaseFitbaseBlock implements ContainerAwareInterface
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
    public function getRoles()
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
            'template' => 'User/Block/UserProfileFocus.html.twig',
        ));
    }

    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        if (!($user = $this->container->get('user')->current())) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        if (($focus = $user->getFocus())) {

            $form = $this->container->get('form.factory')->create(new UserFocusPriorityForm($user), $focus);
            if ($this->container->get('request')->get($form->getName())) {
                $form->handleRequest($this->container->get('request'));
                if ($form->isValid()) {

                    $event = new UserFocusEvent($focus);
                    $this->container->get('event_dispatcher')->dispatch('fitbase.user_focus_update', $event);

                    $this->container->get('entity_manager')->refresh($focus);

                    $form = $this->container->get('form.factory')->create(new UserFocusPriorityForm($user), $focus);
                }
            }

            return $this->renderResponse($blockContext->getSetting('template'), array(
                'user' => $user,
                'form' => $form->createView(),
            ));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Focus (Profile)';
    }
} 