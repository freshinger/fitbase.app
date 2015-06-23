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
            'fitbase.company_category_update' => ['onCompanyCategoryUpdateEvent'],
        ];
    }

    /**
     *
     * @param CompanyCategoryEvent $event
     */
    public function onCompanyCategoryUpdateEvent(CompanyCategoryEvent $event)
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

        if (($companyQuestionnaire = $companyCategory->getQuestionnaire())) {
            if (!($questionnaire = $companyQuestionnaire->getQuestionnaire())) {
                throw new \LogicException('Questionnaire object can not be empty');
            }

            if (($questionnaireCategory = $category->getQuestionnaire())) {
                if ($questionnaireCategory->getId() == $questionnaire->getId()) {

                    return;
                }
            }
        }

        if (($questionnaire = $category->getQuestionnaire())) {
            $this->doCreateCompanyQuestionnaire($company, $questionnaire, $companyCategory);
        }
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


            $this->doCreateCompanyQuestionnaire($company, $questionnaire, $companyCategory);

//            $entity = (new CompanyQuestionnaire())
//                ->setCompany($company)
//                ->setQuestionnaire($questionnaire)
//                ->setPause(0);
//
//            $entityManager = $this->container->get('entity_manager');
//            $entityManager->persist($entity);
//            $entityManager->flush($entity);
//            $entityManager->refresh($entity);
//
//            $companyCategory->setQuestionnaire($entity);
//            $entityManager->persist($entity);
//            $entityManager->flush($entity);
        }
    }

    protected function doCreateCompanyQuestionnaire($company, $questionnaire, $companyCategory)
    {
        $entityManager = $this->container->get('entity_manager');
        $repository = $entityManager->getRepository('Fitbase\Bundle\CompanyBundle\Entity\CompanyQuestionnaire');

        $options = [
            'company' => $company,
            'questionnaire' => $questionnaire,
        ];

        if (!($entity = $repository->findOneBy($options))) {

            $entity = (new CompanyQuestionnaire())
                ->setCompany($company)
                ->setQuestionnaire($questionnaire)
                ->setPause(0);

            $entityManager->persist($entity);
            $entityManager->flush($entity);
            $entityManager->refresh($entity);
        }


        $companyCategory->setQuestionnaire($entity);
        $entityManager->persist($companyCategory);
        $entityManager->flush($companyCategory);
    }
}