<?php

namespace Fitbase\Bundle\UserBundle\Subscriber;


use Fitbase\Bundle\CompanyBundle\Event\CompanyCategoryEvent;
use Fitbase\Bundle\UserBundle\Entity\UserFocusCategory;
use Fitbase\Bundle\UserBundle\Event\UserFocusCategoryEvent;
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
            'user_focus_category_created' => array('onUserFocusCategoryCreatedEvent', -128),
            'user_focus_category_updated' => array('onUserFocusCategoryUpdatedEvent', -128),

            'company_category_created' => array('onCompanyCategoryCreatedEvent', -128),
            'company_category_removed' => array('onCompanyCategoryRemovedEvent', -128),
        );
    }

    /**
     * Process created UserFocusCategory
     * @param UserFocusCategoryEvent $event
     */
    public function onUserFocusCategoryCreatedEvent(UserFocusCategoryEvent $event)
    {
        $this->onUserFocusCategoryUpdatedEvent($event);
    }

    /**
     * Process updated UserFocusCategory
     * @param UserFocusCategoryEvent $event
     */
    public function onUserFocusCategoryUpdatedEvent(UserFocusCategoryEvent $event)
    {
        $entityManager = $this->container->get('entity_manager');
        if (($userFocusCategory = $event->getEntity())) {
            // Attach automatically parent
            // focus category to current focus category
            // if real category has a parent and
            // this parent was attached to focus
            $entityManager = $this->container->get('entity_manager');
            $repositoryUserFocusCategory = $entityManager->getRepository('Fitbase\Bundle\UserBundle\Entity\UserFocusCategory');

            if (($category = $userFocusCategory->getCategory())) {
                $parentCategory = null;
                if (($parentCategory = $category->getParent())) {
                    if (!($parentFocusCategory = $repositoryUserFocusCategory->findOneByCategory($parentCategory))) {
                        // TODO: ...
                    }
                }
                $userFocusCategory->setParent($parentFocusCategory);
                $entityManager->persist($userFocusCategory);
            }

            $entityManager->flush();
        }
    }

    /**
     * On new company category object created
     * @param CompanyCategoryEvent $event
     */
    public function onCompanyCategoryCreatedEvent(CompanyCategoryEvent $event)
    {
        $entityManager = $this->container->get('entity_manager');
        if (($companyCategory = $event->getEntity())) {
            if (($company = $companyCategory->getCompany())) {
                if (($users = $company->getUsers())) {

                    // Create new user focus categories
                    // for all user from company
                    foreach ($users as $user) {
                        if (($focus = $user->getFocus())) {

                            $focusCategory = new UserFocusCategory();
                            $focusCategory->setFocus($focus);
                            $focusCategory->setCategory($companyCategory->getCategory());
                            $focusCategory->setPriority(count($focus->getCategories()));

                            $entityManager->persist($focusCategory);
                            $entityManager->flush($focusCategory);

                            $focus->addCategory($focusCategory);

                            $entityManager->persist($focus);
                            $entityManager->flush($focus);

                            $event = new UserFocusCategoryEvent($focusCategory);
                            $this->container->get('event_dispatcher')->dispatch('user_focus_category_created', $event);
                        }
                    }
                }
            }
        }
    }

    /**
     * Process event on remove company category
     * @param CompanyCategoryEvent $event
     */
    public function onCompanyCategoryRemovedEvent(CompanyCategoryEvent $event)
    {
        $entityManager = $this->container->get('entity_manager');
        $repositoryUserFocusCategory = $entityManager->getRepository('Fitbase\Bundle\UserBundle\Entity\UserFocusCategory');

        if (($companyCategory = $event->getEntity())) {
            if (($category = $companyCategory->getCategory())) {
                if (($company = $companyCategory->getCompany())) {
                    if (($users = $company->getUsers())) {

                        foreach ($users as $user) {
                            if (($focus = $user->getFocus())) {
                                // Remove all user focus categories
                                // if that was removed from company
                                if (($collection = $repositoryUserFocusCategory->findAllByFocusAndCategory($focus, $category))) {
                                    foreach ($collection as $userFocusCategory) {
                                        $entityManager->remove($userFocusCategory);
                                        $entityManager->flush($userFocusCategory);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}