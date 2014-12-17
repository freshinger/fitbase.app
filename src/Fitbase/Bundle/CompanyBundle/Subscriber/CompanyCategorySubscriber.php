<?php

namespace Fitbase\Bundle\CompanyBundle\Subscriber;

use Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory;
use Fitbase\Bundle\ExerciseBundle\Event\CategoryEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Fitbase\Bundle\CompanyBundle\Event\CompanyCategoryEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CompanyCategorySubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            // Listen category events
            // to remove or create new
            // connections with company
            'category_update' => array('onCategoryUpdateEvent', -128),
            'category_remove' => array('onCategoryRemoveEvent', 128),

            'company_category_created' => array('onCompanyCategoryCreatedEvent', -128),
            'company_category_updated' => array('onCompanyCategoryUpdatedEvent', -128),
            'company_category_removed' => array('onCompanyCategoryRemovedEvent', -128),
        );
    }

    /**
     * Check for category remove event
     * @param CategoryEvent $event
     */
    public function onCategoryRemoveEvent(CategoryEvent $event)
    {
        $entityManager = $this->container->get('entity_manager');
        if (($category = $event->getEntity())) {
            $repositoryCompanyCategory = $entityManager->getRepository('Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory');

            // Find all company category object
            // by current category parent
            if (($collectionCompanyCategory = $repositoryCompanyCategory->findByCategory($category))) {
                foreach ($collectionCompanyCategory as $companyCategory) {

                    // Check if no association exists
                    // create new association for parent current category
                    // and company from parent category
                    if (($entity = $repositoryCompanyCategory->findOneByCategory($category))) {


                        $eventChild = new CompanyCategoryEvent($entity);
                        $this->container->get('event_dispatcher')->dispatch('company_category_removed', $eventChild);
                    }
                }
            }
        }
    }

    /**
     * Check for category update event
     * @param CategoryEvent $event
     */
    public function onCategoryUpdateEvent(CategoryEvent $event)
    {
        $entityManager = $this->container->get('entity_manager');
        if (($category = $event->getEntity())) {

            if (($parent = $category->getParent())) {
                $repositoryCompanyCategory = $entityManager->getRepository('Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory');

                // Find all company category object
                // by current category parent
                if (($collectionCompanyCategory = $repositoryCompanyCategory->findByCategory($parent))) {
                    foreach ($collectionCompanyCategory as $companyCategory) {

                        // Check if no association exists
                        // create new association for parent current category
                        // and company from parent category
                        if (!($repositoryCompanyCategory->findOneByCategory($category))) {

                            $entity = new CompanyCategory();
                            $entity->setCategory($category);
                            $entity->setCompany($companyCategory->getCompany());

                            $eventChild = new CompanyCategoryEvent($entity);
                            $this->container->get('event_dispatcher')->dispatch('company_category_updated', $eventChild);
                        }
                    }
                }
            }
        }
    }

    /**
     *
     * @param CompanyCategoryEvent $event
     */
    public function onCompanyCategoryCreatedEvent(CompanyCategoryEvent $event)
    {

    }

    /**
     * @param CompanyCategoryEvent $event
     */
    public function onCompanyCategoryUpdatedEvent(CompanyCategoryEvent $event)
    {
//        $entityManager = $this->container->get('entity_manager');
//        if (($companyCategory = $event->getEntity())) {
//
//            $entityManager->persist($companyCategory);
//            $entityManager->flush($companyCategory);
//
//            if (($category = $companyCategory->getCategory())) {
//                $repositoryCategory = $entityManager->getRepository('Application\Sonata\ClassificationBundle\Entity\Category');
//
//                if (($children = $repositoryCategory->findByParent($category))) {
//                    $repositoryCompanyCategory = $entityManager->getRepository('Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory');
//                    foreach ($children as $index => $categoryChild) {
//                        if (!($repositoryCompanyCategory->findOneByCategory($categoryChild))) {
//
//                            $entity = new CompanyCategory();
//                            $entity->setCompany($companyCategory->getCompany());
//                            $entity->setCategory($categoryChild);
//
//                            $eventChild = new CompanyCategoryEvent($entity);
//                            $this->container->get('event_dispatcher')->dispatch('company_category_updated', $eventChild);
//                        }
//                    }
//                }
//            }
//        }

    }

    /**
     * Check for remove event
     * @param CompanyCategoryEvent $event
     */
    public function onCompanyCategoryRemovedEvent(CompanyCategoryEvent $event)
    {
//        if (($companyCategory = $event->getEntity())) {
//
//            $entityManager = $this->container->get('entity_manager');
//            if (($category = $companyCategory->getCategory())) {
//
//                $repositoryCategory = $entityManager->getRepository('Application\Sonata\ClassificationBundle\Entity\Category');
//                if (($children = $repositoryCategory->findByParent($category))) {
//
//                    $repositoryCompanyCategory = $entityManager->getRepository('Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory');
//                    foreach ($children as $index => $categoryChild) {
//                        if (($entity = $repositoryCompanyCategory->findOneByCategory($categoryChild))) {
//
//                            $eventChild = new CompanyCategoryEvent($entity);
//                            $this->container->get('event_dispatcher')->dispatch('company_category_removed', $eventChild);
//                        }
//                    }
//                }
//            }
//
//            $unitOfWork = $entityManager->getUnitOfWork();
//            if ($unitOfWork->getEntityState($companyCategory) == \Doctrine\ORM\UnitOfWork::STATE_MANAGED) {
//                $entityManager->remove($companyCategory);
//                $entityManager->flush($companyCategory);
//            }
//        }
    }

}