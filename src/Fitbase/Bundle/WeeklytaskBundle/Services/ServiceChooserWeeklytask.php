<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Services;

use Symfony\Component\DependencyInjection\ContainerAware;

class ServiceChooserWeeklytask extends ContainerAware
{
    /**
     * Choose weeklytask using user focus
     * @param $user
     * @return null
     */
    public function choose($user, \DateTime $datetime = null)
    {
        if (!$this->isAccessAllowed($user, $datetime)) {
            return null;
        }

        // Find user focus object
        // in user-focus table
        if (($focus = $this->container->get('focus')->focus($user))) {
            if (($weeklytask = $this->fromFocus($user, $focus))) {
                return $weeklytask;
            }
        }

        // If user have no focus
        // work with all categories, assigned
        // to company with respect to category-priority
        if (($company = $user->getCompany())) {
            if (($weeklytask = $this->fromCompany($user, $company))) {
                return $weeklytask;
            }
        }

        return null;
    }

    /**
     * Get weeklytask from focus
     *
     * @param $user
     * @param $focus
     * @return null
     */
    protected function fromFocus($user, $focus)
    {
        // Choose weeklytask
        // using categories attached to user focus
        // and with respect to priority, defined for all categories
        if (($focusCategories = $focus->getCategories())) {
            foreach ($focusCategories as $focusCategory) {
                if (($weeklytask = $this->fromFocusCategory($user, $focusCategory))) {
                    return $weeklytask;
                }
            }
        }
        return null;
    }

    /**
     * Choose weeklytask from category
     *
     * TODO: append catgory interface to all (CompanyCategory, UserFocusCategory)
     * @param $user
     * @param $focusCategory
     * @return null
     */
    protected function fromFocusCategory($user, $focusCategory)
    {
        if ($this->isAccessAllowed($user, $focusCategory)) {

            if (($children = $focusCategory->getChildren())) {
                foreach ($children as $child) {
                    if (($weeklytask = $this->fromFocusCategory($user, $child))) {
                        return $weeklytask;
                    }
                }
            }

            if (($category = $focusCategory->getCategory())) {

                $entityManager = $this->container->get('entity_manager');
                $repositoryWeeklytask = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask');

                if (($weeklytasks = $repositoryWeeklytask->findByCategory($category))) {
                    foreach ($weeklytasks as $weeklytask) {
                        if ($this->isAccessAllowed($user, $weeklytask)) {
                            return $weeklytask;
                        }
                    }
                }
            }
        }

        return null;
    }

    /**
     * Find weeklytask from company
     *
     * @param $user
     * @param $company
     * @return null
     */
    protected function fromCompany($user, $company)
    {
        if (($companyCategories = $company->getCategories())) {
            foreach ($companyCategories as $companyCategory) {
                if (($weeklytask = $this->fromCompanyCategory($user, $companyCategory))) {
                    return $weeklytask;
                }
            }
        }
        return null;
    }

    /**
     * Find weeklytask from by company category
     *
     * @param $user
     * @param $companyCategory
     * @return null
     */
    protected function fromCompanyCategory($user, \Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory $companyCategory)
    {
        if ($this->isAccessAllowed($user, $companyCategory)) {

            // TODO: add parent relations
            if (($category = $companyCategory->getCategory())) {

                $entityManager = $this->container->get('entity_manager');
                $repositoryWeeklytask = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask');
                if (($weeklytasks = $repositoryWeeklytask->findByCategory($category))) {

                    foreach ($weeklytasks as $weeklytask) {
                        if ($this->isAccessAllowed($user, $weeklytask)) {
                            return $weeklytask;
                        }
                    }
                }
            }
        }

        return null;
    }


    /**
     * Check is that object acceptable for this user
     * @param $user
     * @param $object
     * @return bool
     */
    protected function isAccessAllowed($user, $object)
    {
        $entityManager = $this->container->get('entity_manager');

        if ($object instanceof \DateTime) {
            $repositoryWeeklytaskUser = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser');
            return !$repositoryWeeklytaskUser->findOneByUserAndDateTime($user, $object);
        }

        if ($object instanceof \Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory) {
            $repositoryCompanyCategory = $entityManager->getRepository('Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory');
            return !!$repositoryCompanyCategory->findOneByCompanyAndCategory($user->getCompany(), $object->getCategory());
        }

        if ($object instanceof \Fitbase\Bundle\UserBundle\Entity\UserFocusCategory) {
            $repositoryCompanyCategory = $entityManager->getRepository('Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory');
            return !!$repositoryCompanyCategory->findOneByCompanyAndCategory($user->getCompany(), $object->getCategory());
        }

        if ($object instanceof \Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask) {
            $repositoryWeeklytaskUser = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser');
            return !$repositoryWeeklytaskUser->findOneByUserAndTask($user, $object);
        }
        return false;
    }
}