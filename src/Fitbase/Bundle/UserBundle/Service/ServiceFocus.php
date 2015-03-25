<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 20/11/14
 * Time: 15:26
 */

namespace Fitbase\Bundle\UserBundle\Service;


use Doctrine\Common\Collections\Collection;
use Symfony\Component\DependencyInjection\ContainerAware;

class ServiceFocus extends ContainerAware
{
    /**
     * Get focus for current user
     * @return null
     */
    public function current()
    {
        if (($user = $this->container->get('user')->current())) {
            if (($focus = $user->getFocus())) {
                return $focus;
            }
        }
        return null;
    }

    /**
     * Get actual focus categories
     * @return array
     */
    public function categories()
    {
        if (($focus = $this->current())) {
            if (($focusCategoryFirst = $focus->getFirstCategory())) {
                // for selected primary categories from user
                // process that and return only selected categories
                if (($primaries = $focusCategoryFirst->getPrimaries())) {
                    // only if collection not empty
                    if (($primaries->count())) {
                        return $primaries->map(function ($entity) {
                            // Get real categories from user
                            // focus categories and return as array
                            return $entity->getCategory();
                        })->toArray();
                    }
                }
                // By default return all root categories
                // from user focus
                return $focus->getFirstCategories();
            }
        }
        return array();
    }

    /**
     * Get user focus
     * @param $user
     * @return mixed
     */
    public function focus($user)
    {
        $entityManager = $this->container->get('entity_manager');
        $repositoryUserFocus = $entityManager->getRepository('Fitbase\Bundle\UserBundle\Entity\UserFocus');
        return $repositoryUserFocus->findOneByUser($user);
    }

    /**
     * Check main category slug for user focus
     * @param $user
     * @param null $mixed
     * @return bool
     */
    public function check($user, $mixed = null)
    {
        if (is_string($mixed)) {
            if (($focus = $this->focus($user))) {
                if (($focusCategory = $focus->getFirstCategory())) {
                    if (($category = $focusCategory->getCategory())) {
                        return $category->getSlug() == $mixed;
                    }
                }
            }
        }
        return false;
    }


}