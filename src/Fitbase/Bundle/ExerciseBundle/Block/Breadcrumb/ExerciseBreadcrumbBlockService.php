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

class ExerciseBreadcrumbBlockService extends ExercisesBreadcrumbBlockService
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

        if (($exercise = $repositoryExercise->findOneById($this->container->get('request')->get('unique')))) {
            $menu->addChild($exercise->getName(), array(
                'route' => 'exercise',
                'routeParameters' => array(
                    'unique' => $this->container->get('request')->get('unique')
                ),
                'extras' => array('translation_domain' => 'FitbaseExerciseBundle')
            ));
        }


        return $menu;
    }
} 