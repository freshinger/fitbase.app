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

class CategoryBreadcrumbBlockService extends ExercisesBreadcrumbBlockService
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'fitbase.exercises.category.block.breadcrumb';
    }

    /**
     * {@inheritdoc}
     */
    protected function getMenu(BlockContextInterface $blockContext)
    {
        $menu = parent::getRootMenu($blockContext);

        $menu->addChild('Kategorie', array(
            'route' => 'exercises_category',
            'routeParameters' => array(
                'unique' => $this->container->get('request')->get('unique')
            ),
            'extras' => array('translation_domain' => 'FitbaseExerciseBundle')
        ));

        return $menu;
    }
} 