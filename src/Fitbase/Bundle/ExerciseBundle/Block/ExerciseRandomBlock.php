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

class ExerciseRandomBlock extends BaseBlockService
{
    /**
     * Define
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'category' => null,
            'template' => 'Exercise/Block/ExerciseRandom.html.twig',
        ));
    }

    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $exercise = null;
        if (($category = $blockContext->getSetting('category'))) {
            if (($exercises = $category->getExercises())) {

                if ($exercises instanceof Collection) {
                    $exercises = $exercises->toArray();
                }

                if (count($exercises)) {
                    foreach ($exercises as $id => $exerciseCache) {
                        if ($exerciseCache->getWebm() or $exerciseCache->getMp4()) {
                            unset($exercises[$id]);
                        }
                    }
                }

                if (shuffle($exercises)) {
                    $exercise = array_shift($exercises);
                }
            }
        }

        return $this->renderPrivateResponse($blockContext->getSetting('template'), array(
            'exercise' => $exercise
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Random exercise page (Exercise)';
    }
} 