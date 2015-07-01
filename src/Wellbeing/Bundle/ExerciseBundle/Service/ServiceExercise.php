<?php
namespace Wellbeing\Bundle\ExerciseBundle\Service;


use Application\Sonata\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAware;
use Wellbeing\Bundle\ApiBundle\Model\UserState;
use Wellbeing\Bundle\ExerciseBundle\Form\DataTransformer\UserStateDataTransformer;

class ServiceExercise extends ContainerAware
{
    /**
     * Store user state for stress module
     *
     * @param User $user
     * @param UserState $model
     * @return bool
     */
    public function state(User $user, UserState $model)
    {
        $entity = (new UserStateDataTransformer())
            ->reverseTransform($model)
            ->setUser($user);

        $this->container->get('entity_manager')->persist($entity);
        $this->container->get('entity_manager')->flush($entity);

        return true;
    }
} 