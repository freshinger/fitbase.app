<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\ExerciseBundle\Block;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUserChoice;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserChoiceBlock extends BaseBlockService implements ContainerAwareInterface
{

    /**
     *
     * @var
     */
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
            'exercise' => null,
            'template' => 'Exercise/Block/UserChoice.html.twig',
        ));
    }

    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $exerciseUserChoice = null;
        if (($exercise = $blockContext->getSetting('exercise'))) {
            if (($user = $this->container->get('user')->current())) {
                $entityManager = $this->container->get('entity_manager');
                $repositoryExerciseUserChoice = $entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUserChoice');

                if (!($exerciseUserChoice = $repositoryExerciseUserChoice->findOneByUserAndExercise($user, $exercise))) {
                    if (($this->container->get('request')->get('like', false))) {

                        $exerciseUserChoice = new ExerciseUserChoice();
                        $exerciseUserChoice->setUser($user);
                        $exerciseUserChoice->setExercise($exercise);
                        $exerciseUserChoice->setDate($this->container->get('datetime')->getDateTime());

                        $this->container->get('entity_manager')->persist($exerciseUserChoice);
                        $this->container->get('entity_manager')->flush($exerciseUserChoice);
                    }
                }
            }
        }

        return $this->renderPrivateResponse($blockContext->getSetting('template'), array(
            'exercise' => $exercise,
            'exerciseUserChoice' => $exerciseUserChoice,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Button to mark exercise as selected (Exercise)';
    }

}