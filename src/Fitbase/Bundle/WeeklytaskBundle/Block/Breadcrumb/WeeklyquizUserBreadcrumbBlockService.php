<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 06/11/14
 * Time: 16:11
 */

namespace Fitbase\Bundle\WeeklytaskBundle\Block\Breadcrumb;

use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\SeoBundle\Block\Breadcrumb\BaseBreadcrumbMenuBlockService;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class WeeklyquizUserBreadcrumbBlockService extends WeeklytasksBreadcrumbBlockService implements ContainerAwareInterface
{
    protected $container;

    /**
     *
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'fitbase.weeklyquiz.block.breadcrumb';
    }

    /**
     * {@inheritdoc}
     */
    protected function getMenu(BlockContextInterface $blockContext)
    {
        $menu = parent::getRootMenu($blockContext);

        if (($user = $this->container->get('user')->current())) {
            $entityManager = $this->container->get('entity_manager');
            $repositoryWeeklyquiz = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser');
            if (($weeklyquizUser = $repositoryWeeklyquiz->find($this->container->get('request')->get('unique')))) {
                if (($weeklyquiz = $weeklyquizUser->getQuiz())) {
                    $menu->addChild($weeklyquiz->getName(), array(
                        'route' => 'weeklyquiz_user_view',
                        'routeParameters' => array(
                            'unique' => $this->container->get('request')->get('unique')
                        ),
                        'extras' => array('translation_domain' => 'FitbaseWeeklytaskBundle')
                    ));
                }
            }
        }


        return $menu;
    }
}