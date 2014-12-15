<?php

namespace Fitbase\Bundle\ExerciseBundle\Service;

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
class ServiceChooserExercise extends ContainerAware
{
    /**
     * @param $user
     * @param null $unique
     * @return null
     */
    public function exercise($user, $unique = null)
    {
        $exercises = $this->choose($user, null);
        $entityManager = $this->container->get('entity_manager');
        $repositoryExercise = $entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\Exercise');
        if (($exerciseExtra = $repositoryExercise->findOneById($unique))) {
            if ($exerciseExtra instanceof Exercise) {
                $exercises[0] = $exerciseExtra;
            }
        }
        return $exercises;
    }

    /**
     * Choose a exercises
     * @param $user
     * @param \DateTime $datetime
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
            if (($result = $this->fromFocus($user, $focus))) {
                return $result;
            }
        }

        // If user have no focus
        // work with all categories, assigned
        // to company with respect to category-priority
        if (($company = $user->getCompany())) {
            if (($result = $this->fromCompany($user, $company))) {
                return $result;
            }
        }

        return null;

    }

    /**
     * Get exercise from focus
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
                if (($result = $this->fromFocusCategory($user, $focusCategory))) {
                    return $result;
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
        // Check is current category
        // allowed by company or other thing
        if (!$this->isAccessAllowed($user, $focusCategory)) {
            return null;
        }

        if (($children = $focusCategory->getChildren())) {
            foreach ($children as $child) {
                if (($result = $this->fromFocusCategory($user, $child))) {
                    return $result;
                }
            }
        }

        $exercises = array();
        if (($category = $focusCategory->getCategory())) {
            if (($exercise0 = $this->fromUserAndCategoryAndType($user, $category, Exercise::MOBILISATION))) {
                if (($exercise1 = $this->fromUserAndCategoryAndType($user, $category, Exercise::KRAEFTIGUNG))) {
                    if (($exercise2 = $this->fromUserAndCategoryAndType($user, $category, Exercise::DAEHNUNG))) {
                        array_push($exercises, $exercise0);
                        array_push($exercises, $exercise1);
                        array_push($exercises, $exercise2);
                    }
                }
            }
        }
        return $exercises;
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
                if (($result = $this->fromCompanyCategory($user, $companyCategory))) {
                    return $result;
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
        // Check is current category
        // allowed by company or other thing
        if (!$this->isAccessAllowed($user, $companyCategory)) {
            return null;
        }

        // TODO: Add this one but for company category object
//        if (($children = $focusCategory->getChildren())) {
//            foreach ($children as $child) {
//                if (($result = $this->fromFocusCategory($user, $child))) {
//                    return $result;
//                }
//            }
//        }

        $exercises = array();
        if (($category = $companyCategory->getCategory())) {
            if (($exercise0 = $this->fromUserAndCategoryAndType($user, $category, Exercise::MOBILISATION))) {
                if (($exercise1 = $this->fromUserAndCategoryAndType($user, $category, Exercise::KRAEFTIGUNG))) {
                    if (($exercise2 = $this->fromUserAndCategoryAndType($user, $category, Exercise::DAEHNUNG))) {
                        array_push($exercises, $exercise0);
                        array_push($exercises, $exercise1);
                        array_push($exercises, $exercise2);
                    }
                }
            }
        }

        return $exercises;
    }

    /**
     * Find a exercise from category and type
     * @param $user
     * @param $category
     * @param $type
     * @return null
     */
    protected function fromUserAndCategoryAndType($user, $category, $type)
    {
        $entityManager = $this->container->get('entity_manager');
        $repositoryExercise = $entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\Exercise');

        // If no exercises found break down
        if (!($exercises = $repositoryExercise->findByCategoryAndType($category, $type))) {
            return null;
        }

        // Check is current exercise
        // allowed by company or other thing
        foreach ($exercises as $exercise) {
            if ($this->isAccessAllowed($user, $exercise)) {
                return $exercise;
            }
        }

        // randomize exercises and
        // and get one element
        if (shuffle($exercises)) {
            return array_shift($exercises);
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
            $repositoryExerciseUser = $entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser');
            return !$repositoryExerciseUser->findOneByUserAndDateTime($user, $object);
        }

        if ($object instanceof \Fitbase\Bundle\UserBundle\Entity\UserFocusCategory) {
            $repositoryCompanyCategory = $entityManager->getRepository('Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory');
            return !!$repositoryCompanyCategory->findOneByCompanyAndCategory($user->getCompany(), $object->getCategory());
        }

        if ($object instanceof \Fitbase\Bundle\ExerciseBundle\Entity\Exercise) {
            $repositoryExerciseUser = $entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\ExerciseUser');
            return !$repositoryExerciseUser->findOneByUserAndExercise($user, $object);
        }

        if ($object instanceof \Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory) {
            $repositoryCompanyCategory = $entityManager->getRepository('Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory');
            return !!$repositoryCompanyCategory->findOneByCompanyAndCategory($user->getCompany(), $object->getCategory());
        }


        return true;
    }
}