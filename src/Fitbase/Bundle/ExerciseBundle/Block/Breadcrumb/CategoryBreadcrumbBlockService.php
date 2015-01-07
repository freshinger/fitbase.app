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

class CategoryBreadcrumbBlockService extends FocusBreadcrumbBlockService
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'fitbase.category.block.breadcrumb';
    }

    /**
     * {@inheritdoc}
     */
    protected function getMenu(BlockContextInterface $blockContext)
    {
        $menu = parent::getRootMenu($blockContext);

        $entityManager = $this->container->get('entity_manager');
        $repositoryCategory = $entityManager->getRepository('Application\Sonata\ClassificationBundle\Entity\Category');

        $request = $this->container->get('request');
        $slug = $request->get('slug');

        if (($category = $repositoryCategory->findOneBySlug($slug))) {

            $menu->addChild($category->getName(), array(
                'route' => 'category',
                'routeParameters' => array(
                    'slug' => $slug,

                ),
                'extras' => array('translation_domain' => 'FitbaseExerciseBundle')
            ));
        }

        return $menu;
    }
} 