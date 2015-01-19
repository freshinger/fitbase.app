<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 20/11/14
 * Time: 15:26
 */

namespace Fitbase\Bundle\UserBundle\Service;


use Fitbase\Bundle\UserBundle\Entity\UserSingleSignOn;
use Fitbase\Bundle\UserBundle\Event\UserSingleSignOnEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

class ServiceSingleSignOn extends ContainerAware
{
    /**
     * @param $user
     * @return null|string
     */
    public function code($user)
    {
        if (($code = $this->container->get('codegenerator')->password(32))) {

            $entityManager = $this->container->get('entity_manager');
            if(\Doctrine\ORM\UnitOfWork::STATE_MANAGED === $entityManager->getUnitOfWork()->getEntityState($user)) {

                $entity = new UserSingleSignOn();
                $entity->setUser($user);
                $entity->setProcessed(0);
                $entity->setCode($code);
                $entity->setDate($this->container->get('datetime')->getDateTime('now'));


                $event = new UserSingleSignOnEvent($entity);
                $this->container->get('event_dispatcher')->dispatch('user_singlesignon_create', $event);

                return $entity->getCode();
            }
        }

        return null;
    }
}