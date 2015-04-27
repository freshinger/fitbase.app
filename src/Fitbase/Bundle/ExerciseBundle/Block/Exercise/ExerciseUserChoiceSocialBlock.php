<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\ExerciseBundle\Block\Exercise;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUserChoice;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ExerciseUserChoiceSocialBlock extends BaseBlockService implements ContainerAwareInterface
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
            'template' => 'Exercise/Block/UserChoiceSocial.html.twig',
        ));
    }

    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $entityManager = $this->container->get('entity_manager');
        $repositoryExerciseUserChoice = $entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUserChoice');

        $collection = array();
        if (($user = $this->container->get('user')->current())) {
            if (($focus = $this->container->get('focus')->current())) {
                if (($categories = $focus->getParentCategories())) {

                    $categories = $categories->map(function ($entity) {
                        return $entity->getCategory();
                    });

                    $collection = $repositoryExerciseUserChoice->findPopularByCategories($categories, 6);
                }
            }

        }


        return $this->renderPrivateResponse($blockContext->getSetting('template'), array(
            'collection' => $collection,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'User choice (Exercise)';
    }

}