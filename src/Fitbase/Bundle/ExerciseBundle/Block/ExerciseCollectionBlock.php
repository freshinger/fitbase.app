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
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ExerciseCollectionBlock extends BaseBlockService
{
    /**
     * Define
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'categories' => array(),
            'template' => 'Exercise/Block/ExerciseCollection.html.twig',
        ));
    }

    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $exercises = array();
        if (($categories = $blockContext->getSetting('categories'))) {
            if (($category = $categories->first())) {
                $exercises = $category->getExercises();
            }
        }

        return $this->renderPrivateResponse($blockContext->getSetting('template'), array(
            'exercises' => $exercises
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Exercise list page (Exercise)';
    }
} 