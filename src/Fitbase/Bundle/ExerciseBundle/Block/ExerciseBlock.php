<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\ExerciseBundle\Block;


use Fitbase\Bundle\ExerciseBundle\Event\ExerciseEvent;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ExerciseBlock extends BaseBlockService implements ContainerAwareInterface
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
     * Set default settings for this block
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'unique' => null,
            'template' => 'Exercise/Block/Exercise.html.twig',
        ));
    }

    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $exercise = null;
        if (!($user = $this->container->get('user')->current())) {
            throw new \LogicException('User object can not be empty');
        }

        $entityManager = $this->container->get('entity_manager');
        $repositoryExercise = $entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\Exercise');

        if (!($exercise = $repositoryExercise->findOneById($blockContext->getSetting('unique')))) {
            throw new \LogicException('Exercise object can not be empty');
        }

        $event = new ExerciseEvent($exercise);
        $this->container->get('event_dispatcher')->dispatch('fitbase.exercise_process', $event);

        return $this->renderPrivateResponse($blockContext->getSetting('template'), array(
            'exercise' => $exercise
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Exercise (Exercise)';
    }
} 