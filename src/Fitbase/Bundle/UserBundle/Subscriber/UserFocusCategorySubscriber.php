<?php

namespace Fitbase\Bundle\UserBundle\Subscriber;


use Fitbase\Bundle\CompanyBundle\Event\CompanyCategoryEvent;
use Fitbase\Bundle\UserBundle\Entity\UserFocusCategory;
use Fitbase\Bundle\UserBundle\Event\UserFocusCategoryEvent;
use Fitbase\Bundle\UserBundle\Event\UserFocusEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserFocusCategorySubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'fitbase.user_focus_category_update' => array('onUserFocusCategoryUpdate')
        );
    }

    /**
     * Save updated user focus category
     * @param UserFocusCategoryEvent $event
     */
    public function onUserFocusCategoryUpdate(UserFocusCategoryEvent $event)
    {
        if (($entity = $event->getEntity())) {

            $entityManager = $this->container->get('entity_manager');
            $repositoryUserFocusCategory = $entityManager->getRepository('Fitbase\Bundle\UserBundle\Entity\UserFocusCategory');
            if (($children = $repositoryUserFocusCategory->findByParent($entity))) {
                foreach ($children as $child) {
                    $child->setParent(null);
                    $child->setType(null);
                    $entityManager->persist($child);
                }
                $entityManager->flush();
            }

            if (($priorities = $entity->getPrimaries())) {
                foreach ($priorities as $primary) {
                    $primary->setParent($entity);
                    $primary->setType($entity->getType());
                    $entityManager->persist($primary);
                }
            }

            $entity->setUpdate(false);
            $entityManager->persist($entity);
            $entityManager->flush();
        }
    }
}