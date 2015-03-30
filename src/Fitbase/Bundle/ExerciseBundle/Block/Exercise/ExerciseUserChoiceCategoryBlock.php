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

class ExerciseUserChoiceCategoryBlock extends BaseBlockService implements ContainerAwareInterface
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
            'category' => null,
            'template' => 'FitbaseExerciseBundle:Block:Exercise/UserChoiceCategory.html.twig',
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

        $category = null;
        $collection = array();
        if (($category = $blockContext->getSetting('category'))) {
            if (($user = $this->container->get('user')->current())) {
                $collection = $repositoryExerciseUserChoice->findByUserAndCategory($user, $category);
            }
        }

        return $this->renderPrivateResponse($blockContext->getSetting('template'), array(
            'category' => $blockContext->getSetting('category'),
            'collection' => $collection,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'User choice category (Exercise)';
    }

}