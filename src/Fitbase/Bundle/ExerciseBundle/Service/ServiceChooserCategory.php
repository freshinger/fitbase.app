<?php

namespace Fitbase\Bundle\ExerciseBundle\Service;

use Fitbase\Bundle\ExerciseBundle\Component\Chooser\ChooserCompanyCategory;
use Fitbase\Bundle\ExerciseBundle\Component\Chooser\ChooserExercise;
use Fitbase\Bundle\ExerciseBundle\Component\Chooser\ChooserFocusCategory;
use Fitbase\Bundle\ExerciseBundle\Entity\Exercise;
use Sonata\MediaBundle\Model\MediaInterface;
use Sonata\MediaBundle\Provider\FileProvider;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 23/10/14
 * Time: 13:12
 */
class ServiceChooserCategory
{
    /**
     * Store result here
     * @var array
     */
    protected $result = array();

    /**
     * @param callable $filter
     * @return array|mixed
     */
    public function choose(\Fitbase\Bundle\UserBundle\Entity\UserFocus $focus, \Closure $filter = null)
    {
        $this->result = array();
        if (($categories = $focus->getParentCategories())) {
            if (count($categories)) {
                foreach ($categories as $category) {
                    if ($this->category($category)) {
                        continue;
                    }
                }
            }
        }

        return array_unique($this->result);
    }

    /**
     * Process subcategories recursive
     * add to list only categories without
     * a parent - category
     * @param $category
     * @return bool
     */
    protected function category($category)
    {
        if (($children = $category->getChildren())) {
            if (count($children)) {
                foreach ($children as $child) {
                    if ($this->category($child)) {
                        continue;
                    }
                }

                return true;
            }
        }

        if (($category = $category->getCategory())) {
            if (!in_array($category, $this->result)) {
                array_push($this->result, $category);
            }
        }

        return true;
    }
}