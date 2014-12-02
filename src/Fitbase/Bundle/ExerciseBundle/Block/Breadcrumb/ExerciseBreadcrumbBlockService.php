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
        $repositoryExerciseUser = $entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser');

        $request = $this->container->get('request');
        $id = $request->get('unique');

        if (($exerciseUser = $repositoryExerciseUser->findOneById($id))) {

            $exercise = null;
            $step = $request->get('step');
            $methodNames = array('getExercise0', 'getExercise1', 'getExercise2');
            if (isset($methodNames[$step]) and ($method = $methodNames[$step])) {
                $exercise = call_user_func_array(array($exerciseUser, $method), array());
            }

            if (!empty($exercise)) {
                $menu->addChild($exercise->getName(), array(
                    'route' => 'exercise_user',
                    'routeParameters' => array(
                        'step' => $step,
                        'unique' => $exerciseUser->getId(),

                    ),
                    'extras' => array('translation_domain' => 'FitbaseExerciseBundle')
                ));
            }

        }


        return $menu;
    }
} 