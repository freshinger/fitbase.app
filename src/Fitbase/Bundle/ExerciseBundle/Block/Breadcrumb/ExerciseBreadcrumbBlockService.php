<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 06/11/14
 * Time: 16:11
 */

namespace Fitbase\Bundle\ExerciseBundle\Block\Breadcrumb;

use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\SeoBundle\Block\Breadcrumb\BaseBreadcrumbMenuBlockService;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ExerciseBreadcrumbBlockService extends FocusBreadcrumbBlockService
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'fitbase.exercise.block.breadcrumb';
    }

    /**
     * {@inheritdoc}
     */
    protected function getMenu(BlockContextInterface $blockContext)
    {
        $menu = parent::getRootMenu($blockContext);

        $entityManager = $this->container->get('entity_manager');
        $repositoryExercise = $entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\Exercise');

        $request = $this->container->get('request');

        if (($exercise = $repositoryExercise->findOneById($request->get('unique')))) {
            $menu->addChild($exercise->getName(), array(
                'route' => 'exercise',
                'routeParameters' => array(
                    'unique' => $exercise->getId(),

                ),
                'extras' => array('translation_domain' => 'FitbaseExerciseBundle')
            ));
        }

        return $menu;
    }
} 