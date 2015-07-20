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
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Fitbase\Bundle\UserBundle\Form\UserRecoverForm;
use Fitbase\Bundle\UserBundle\Form\UserRemoveForm;
use Fitbase\Bundle\UserBundle\Model\UserRemove;
use Sonata\UserBundle\Model\UserInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AccountRemoveBlock extends BaseFitbaseBlock implements ContainerAwareInterface
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
            'template' => 'User/Block/AccountRemove.html.twig',
        ));
    }

    /**
     * Render block response
     * @param string $view
     * @param array $parameters
     * @param Response $response
     * @return Response
     */
    public function renderResponse($view, array $parameters = array(), Response $response = null)
    {
        if (!($user = $this->container->get('user')->current())) {
            throw new \LogicException('User object can not be empty');
        }

        if ($user->getRemoveRequest()) {
            return $this->renderRecoverResponse($user, $view, $parameters, $response);
        }

        return $this->renderRemoveResponse($user, $view, $parameters, $response);
    }

    /**
     * @param UserInterface $user
     * @param $view
     * @param array $parameters
     * @param Response $response
     * @return Response
     */
    protected function renderRecoverResponse(UserInterface $user, $view, array $parameters = array(), Response $response = null)
    {
        $form = $this->container->get('form.factory')->create(new UserRecoverForm(), new UserRemove());
        if ($this->container->get('request')->get($form->getName())) {
            $form->handleRequest($this->container->get('request'));
            if ($form->isValid()) {

                $this->container->get('event_dispatcher')->dispatch(
                    'fitbase.user_remove_recover', new UserEvent($user));

                return $this->renderRemoveResponse($user, $view, $parameters, $response);
            }
        }

        return $this->getTemplating()->renderResponse('User/Block/AccountRecover.html.twig', array(
            'form' => $form->createView()
        ), $response);
    }


    /**
     * @param UserInterface $user
     * @param $view
     * @param array $parameters
     * @param Response $response
     * @return Response
     */
    protected function renderRemoveResponse(UserInterface $user, $view, array $parameters = array(), Response $response = null)
    {
        $form = $this->container->get('form.factory')->create(new UserRemoveForm(), new UserRemove());
        if ($this->container->get('request')->get($form->getName())) {
            $form->handleRequest($this->container->get('request'));
            if ($form->isValid()) {

                $this->container->get('event_dispatcher')->dispatch(
                    'fitbase.user_remove_prepare', new UserEvent($user));

                return $this->renderRecoverResponse($user, $view, $parameters, $response);
            }
        }

        return $this->getTemplating()->renderResponse($view, array(
            'form' => $form->createView()
        ), $response);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Remove user account (Profile)';
    }
} 