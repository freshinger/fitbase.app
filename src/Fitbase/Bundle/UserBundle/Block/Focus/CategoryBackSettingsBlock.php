<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\UserBundle\Block\Focus;

use Fitbase\Bundle\ReminderBundle\Form\ReminderUserForm;
use Fitbase\Bundle\UserBundle\Event\UserFocusCategoryEvent;
use Fitbase\Bundle\UserBundle\Form\UserFocusCategoryForm;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoryBackSettingsBlock extends BaseBlockService
{
    /**
     * Store container here
     * @var
     */
    protected $request;
    protected $eventDispatcher;
    protected $formFactory;

    public function __construct($name, EngineInterface $templating, $request, $eventDispatcher, $formFactory)
    {
        parent::__construct($name, $templating);

        $this->request = $request;
        $this->eventDispatcher = $eventDispatcher;
        $this->formFactory = $formFactory;
    }


    /**
     * Set defaults
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'focus' => null,
            'template' => 'User/Block/FocusSettingsBack.html.twig',
        ));
    }

    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        if (($focus = $blockContext->getSetting('focus'))) {
            if (($userFocusCategory = $focus->getCategoryBySlug('ruecken'))) {

                $form = $this->formFactory->create(new UserFocusCategoryForm($userFocusCategory), $userFocusCategory);
                if ($this->request->get($form->getName())) {
                    $form->handleRequest($this->request);
                    if ($form->isValid()) {

                        $event = new UserFocusCategoryEvent($userFocusCategory);
                        $this->eventDispatcher->dispatch('fitbase.user_focus_category_update', $event);
                    }
                }

                return $this->renderPrivateResponse($blockContext->getSetting('template'), array(
                    'form' => $form->createView(),
                    'user' => $focus->getUser(),
                ));
            }
        }

        return new Response(null);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Focus category settings';
    }
} 