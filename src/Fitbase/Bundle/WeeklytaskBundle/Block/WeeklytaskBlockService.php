<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\WeeklytaskBundle\Block;


use Doctrine\Common\Collections\ArrayCollection;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WeeklytaskBlockService extends BaseBlockService
{
    /**
     * @var
     */
    protected $eventDispatcher;

    /**
     * @param string $name
     * @param EngineInterface $templating
     */
    public function __construct($name, EngineInterface $templating, $eventDispatcher)
    {
        parent::__construct($name, $templating);

        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Define
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'weeklytaskUser' => null,
            'template' => 'FitbaseWeeklytaskBundle:Block:weeklytask.html.twig',
        ));
    }

    /**
     * Render Weeklytask
     * @param BlockContextInterface $blockContext
     * @param Response $response
     * @return Response
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $weeklytaskUser = null;

        if (($weeklytaskUser = $blockContext->getSetting('weeklytaskUser'))) {
            $event = new WeeklytaskUserEvent($weeklytaskUser);
            $this->eventDispatcher->dispatch('weeklytask_user_done', $event);
        }

        return $this->renderPrivateResponse($blockContext->getSetting('template'), array(
            'weeklytaskUser' => $weeklytaskUser,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Infoeinheit (Wochenaufgaben)';
    }
} 