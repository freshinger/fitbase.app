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
use Fitbase\Bundle\UserBundle\Form\UserFocusPriorityForm;
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

class ProfileFocusBlockService extends BaseBlockService implements ContainerAwareInterface
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
        if (!($user = $this->container->get('user')->current())) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        if (($focus = $user->getFocus())) {

            $form = $this->container->get('form.factory')->create(new UserFocusPriorityForm($user), $focus);
            if ($this->container->get('request')->get($form->getName())) {
                $form->handleRequest($this->container->get('request'));
                if ($form->isValid()) {

                    foreach ($focus->getCategories() as $category) {
                        $this->container->get('entity_manager')->persist($category);
                        $this->container->get('entity_manager')->flush($category);
                    }

                    $this->container->get('entity_manager')->refresh($user);

                    $form = $this->container->get('form.factory')->create(new UserFocusPriorityForm($user), $user->getFocus());
                }
            }

            return $this->renderResponse('FitbaseUserBundle:Block:focus.html.twig', array(
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