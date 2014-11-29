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

class ProfileDashboardBlockService extends BaseBlockService implements ContainerAwareInterface
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
        $user = null;

        if (!($user = $this->container->get('user')->current())) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $form = $this->container->get('sonata.user.profile.form');
        $formHandler = $this->container->get('sonata.user.profile.form.handler');

        if (($process = $formHandler->process($user))) {
            $this->container->get('session')->getFlashBag()
                ->set('sonata_user_success', 'profile.flash.updated');
        }

        $formPassword = $this->container->get('fos_user.change_password.form');
        $formHandlerPassword = $this->container->get('fos_user.change_password.form.handler');

        if (($process = $formHandlerPassword->process($user))) {
            $this->container->get('session')->getFlashBag()
                ->set('fos_user_success', 'change_password.flash.success');
        }

        return $this->renderResponse('FitbaseUserBundle:Block:dashboard.html.twig', array(
            'form' => $form->createView(),
            'formPassword' => $formPassword->createView(),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Dashboard (Profile)';
    }
} 