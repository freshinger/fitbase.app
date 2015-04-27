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
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyquizUserEvent;
use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklytaskUserEvent;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WeeklyquizPendingBlock extends BaseBlockService implements ContainerAwareInterface
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
            'template' => 'Weeklytask/Block/WeeklyquizPending.html.twig',
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
        $entityManager = $this->container->get('entity_manager');
        $repositoryWeeklyquizUser = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser');

        $user = $this->container->get('user')->current();
        return $this->renderPrivateResponse($blockContext->getSetting('template'), array(
            'collection' => $repositoryWeeklyquizUser->findAllNotDoneByUser($user)
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Pending quizze (Wochenaufgaben)';
    }

}