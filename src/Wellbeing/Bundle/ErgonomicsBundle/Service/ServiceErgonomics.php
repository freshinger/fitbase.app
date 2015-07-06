<?php
namespace Wellbeing\Bundle\ErgonomicsBundle\Service;

use Application\Sonata\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAware;
use Wellbeing\Bundle\ApiBundle\Model\UserState;
use Wellbeing\Bundle\ErgonomicsBundle\Event\UserStateErgonomicsEvent;
use Wellbeing\Bundle\ErgonomicsBundle\Form\DataTransformer\UserStateDataTransformer;

class ServiceErgonomics extends ContainerAware
{

    /**
     * Store user state for Ergonomics
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

        $this->container->get('event_dispatcher')->dispatch(
            'wellbeing.user_state_ergonomics_create', new UserStateErgonomicsEvent($entity));

        return true;
    }
}