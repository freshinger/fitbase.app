<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\FitbaseBundle\Block;


use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\BlockServiceInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class FitbaseUserProfileBlock extends BaseBlockService implements ContainerAwareInterface
{

    protected $container;

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Define
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'template' => 'Fitbase/Block/UserProfile.html.twig',
        ));
    }

    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $user = $this->container->get('user')->current();
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

        return $this->renderPrivateResponse($blockContext->getSetting('template'), array(
            'form' => $form->createView(),
            'formPassword' => $formPassword->createView(),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'User profile';
    }


}