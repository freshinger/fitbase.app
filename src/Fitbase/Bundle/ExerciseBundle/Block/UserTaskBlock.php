<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\ExerciseBundle\Block;

use Fitbase\Bundle\ExerciseBundle\Event\ExerciseEvent;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseUserTaskEvent;
use Fitbase\Bundle\FitbaseBundle\Library\Block\BaseFitbaseBlock;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserTaskBlock extends BaseFitbaseBlock implements ContainerAwareInterface
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
     * Get array with roles, for this block
     * @return mixed
     */
    function getRoles()
    {
        return array(
            'ROLE_FITBASE_USER'
        );
    }


    /**
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'step' => 0,
            'task' => null,
            'exercise' => null,
            'template' => 'Exercise/Block/UserTask.html.twig',
        ));
    }

    /**
     * Render response
     *
     * @param string $view
     * @param array $parameters
     * @param Response $response
     * @return Response
     */
    public function renderResponse($view, array $parameters = array(), Response $response = null)
    {
        if (!($exerciseUserTask = $parameters['block_context']->getSetting('task'))) {
            throw new \LogicException("Exercise user task object can not be empty");
        }

        $eventDispatcher = $this->container->get('event_dispatcher');
        if (!($exercise = $parameters['block_context']->getSetting('exercise'))) {
            if (!($exercise = $exerciseUserTask->getExercise0())) {
                throw new \LogicException("Exercise object can not be empty");
            }
        }

        if ($exerciseUserTask->getDone()) {
            $event = new ExerciseEvent($exercise);
            $eventDispatcher->dispatch('fitbase.exercise_process', $event);
        } else {
            $event = new ExerciseUserTaskEvent($exerciseUserTask);
            $eventDispatcher->dispatch('fitbase.exercise_user_task_process', $event);
        }

        return $this->getTemplating()->renderResponse($view, array(
            'step' => $parameters['block_context']->getSetting('step'),
            'task' => $exerciseUserTask,
            'exercise' => $exercise,
        ), $response);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'User task (Exercise)';
    }

}