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

class CategoryExercisesBreadcrumb extends CategoryBreadcrumbBlockService
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'fitbase.category_exercises.block.breadcrumb';
    }

    /**
     * {@inheritdoc}
     */
    protected function getMenu(BlockContextInterface $blockContext)
    {
        $menu = parent::getMenu($blockContext);
        $entityManager = $this->container->get('entity_manager');
        $repositoryCategory = $entityManager->getRepository('Application\Sonata\ClassificationBundle\Entity\Category');


        $request = $this->container->get('request');
        $slug = $request->get('slug');

        if (($category = $repositoryCategory->findOneBySlug($slug))) {
            $menu->addChild("{$category->getName()} - Übungen", array(
                'route' => 'category_exercises',
                'routeParameters' => array(
                    'slug' => $this->container->get('request')->get('slug'),

                ),
                'extras' => array('translation_domain' => 'FitbaseExerciseBundle')
            ));
        }


        return $menu;
    }
} 