<?php

namespace Fitbase\Bundle\ExerciseBundle\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Fitbase\Bundle\ExerciseBundle\Component\Chooser\ChooserCompanyCategory;
use Fitbase\Bundle\ExerciseBundle\Component\Chooser\ChooserExercise;
use Fitbase\Bundle\ExerciseBundle\Component\Chooser\ChooserFocusCategory;
use Fitbase\Bundle\UserBundle\Entity\UserFocus;
use Fitbase\Bundle\UserBundle\Entity\UserFocusCategory;

/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 23/10/14
 * Time: 13:12
 */
class ServiceChooserCategory
{
    /**
     * @param callable $filter
     * @return array|mixed
     */
    public function choose(\Fitbase\Bundle\UserBundle\Entity\UserFocus $focus, \Closure $filter = null)
    {
        $result = array();
        if (count(($focusCategories = $focus->getParentCategories()))) {
            foreach ($focusCategories as $focusCategory) {
                if (($resultCache = $this->category($focus, $focusCategory))) {
                    $result = array_merge($result, $resultCache);
                    continue;
                }
            }
        }

        return $result;
    }

    /**
     * Process subcategories recursive
     * add to list only categories without
     * a parent - category
     * @return bool
     */
    protected function category(UserFocus $focus, UserFocusCategory $focusCategory)
    {
        $result = array();
        if (($category = $focusCategory->getCategory())) {

            if (!in_array($category, $result)) {
                array_push($result, $category);
            }

            $resultChildren = array();
            if (count(($children = $category->getChildren()))) {
                foreach ($children as $child) {
                    if (($focusCategory = $focus->getCategory($child))) {
                        if (($resultCache = $this->category($focus, $focusCategory))) {
                            $resultChildren = array_merge($resultChildren, $resultCache);
                            continue;
                        }
                    }
                }

                usort($resultChildren, array($this, 'sort'));

                $result = array_merge($result, $resultChildren);
            }
        }

        return $result;
    }

    /**
     * Sort array with children
     * @param $entity1
     * @param $entity2
     * @return int
     */
    protected function sort($entity1, $entity2)
    {
        return $entity1->getPosition() >= $entity2->getPosition() ? -1 : 1;
    }
}