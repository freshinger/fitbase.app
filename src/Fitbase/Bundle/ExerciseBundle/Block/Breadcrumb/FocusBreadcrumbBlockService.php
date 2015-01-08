<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 06/11/14
 * Time: 16:11
 */

namespace Fitbase\Bundle\ExerciseBundle\Block\Breadcrumb;

use Fitbase\Bundle\FitbaseBundle\Block\Breadcrumb\FitbaseBreadcrumbBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\SeoBundle\Block\Breadcrumb\BaseBreadcrumbMenuBlockService;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FocusBreadcrumbBlockService extends FitbaseBreadcrumbBlockService implements ContainerAwareInterface
{
    protected $container;

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'fitbase.focus.block.breadcrumb';
    }

    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    protected function getRootMenu(BlockContextInterface $blockContext)
    {
        $menu = parent::getRootMenu($blockContext);

        $menu->addChild('Übungen', array(
            'route' => 'focus',
            'extras' => array('translation_domain' => 'FitbaseExerciseBundle')
        ));

        return $menu;
    }

    /**
     * {@inheritdoc}
     */
    protected function getMenu(BlockContextInterface $blockContext)
    {
        return $this->getRootMenu($blockContext);
    }
} 