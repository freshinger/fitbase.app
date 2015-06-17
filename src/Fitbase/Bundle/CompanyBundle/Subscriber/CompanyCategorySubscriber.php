<?php

namespace Fitbase\Bundle\CompanyBundle\Subscriber;

use Fitbase\Bundle\CompanyBundle\Entity\CompanyQuestionnaire;
use Fitbase\Bundle\CompanyBundle\Event\CompanyCategoryEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CompanyCategorySubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Get subscribers
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'fitbase.company_category_create' => ['onCompanyCategoryCreateEvent'],
        ];
    }

    /**
     * @param CompanyCategoryEvent $event
     */
    public function onCompanyCategoryCreateEvent(CompanyCategoryEvent $event)
    {
        if (!($companyCategory = $event->getEntity())) {
            throw new \LogicException('Company category object can not be empty');
        }

        if (!($company = $companyCategory->getCompany())) {
            throw new \LogicException('Company object can not be empty');
        }

        if (!($category = $companyCategory->getCategory())) {
            throw new \LogicException('Category object can not be empty');
        }

        if (($questionnaire = $category->getQuestionnaire())) {

            $entity = (new CompanyQuestionnaire())
                ->setCompany($company)
                ->setQuestionnaire($questionnaire)
                ->setPause(0);

            $entityManager = $this->container->get('entity_manager');
            $entityManager->persist($entity);
            $entityManager->flush($entity);
            $entityManager->refresh($entity);

            $companyCategory->setQuestionnaire($entity);
            $entityManager->persist($entity);
            $entityManager->flush($entity);

        }
    }
}