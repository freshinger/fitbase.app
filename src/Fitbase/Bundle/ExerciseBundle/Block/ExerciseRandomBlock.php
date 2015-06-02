<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\ExerciseBundle\Block;


use Application\Sonata\ClassificationBundle\Entity\Category;
use Doctrine\Common\Collections\Collection;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseEvent;
use Fitbase\Bundle\FitbaseBundle\Library\Block\BaseFitbaseBlock;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ExerciseRandomBlock extends BaseFitbaseBlock implements ContainerAwareInterface
{
    /**
     * Store container here
     * @var
     */
    protected $container;

    /**
     * Set container
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Get array with roles, for this block
     * @return mixed
     */
    function getRoles()
    {
        return array(
            'ROLE_FITBASE_USER'
        );
    }

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
     * Render block response
     * @param string $view
     * @param array $parameters
     * @param Response $response
     * @return Response
     */
    public function renderResponse($view, array $parameters = array(), Response $response = null)
    {
        $exercise = null;
        if (($category = $parameters['block_context']->getSetting('category'))) {
            if (!($exercise = $this->doSelectExerciseRandom($category))) {
                throw new \LogicException("Exercise object can not be empty");
            }
        }

        $event = new ExerciseEvent($exercise);
        $this->container->get('event_dispatcher')->dispatch('fitbase.exercise_process', $event);

        return $this->getTemplating()->renderResponse($view, array(
            'exercise' => $exercise
        ), $response);
    }

    /**
     * Select random exercise from category
     * @param Category $category
     * @return mixed|null
     */
    protected function doSelectExerciseRandom(Category $category)
    {
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
                return array_shift($exercises);
            }
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Random exercise page (Exercise)';
    }
}