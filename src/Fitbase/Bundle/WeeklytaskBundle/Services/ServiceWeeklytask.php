<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Services;

use Doctrine\Common\Collections\ArrayCollection;
use Fitbase\Bundle\WeeklytaskBundle\Component\Chooser\ChooserWeeklytask;
use Fitbase\Bundle\WeeklytaskBundle\Component\Chooser\ChooserWeeklytaskFilter;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Symfony\Component\DependencyInjection\ContainerAware;

class ServiceWeeklytask extends ContainerAware
{

    /**
     * Create a personal user weeklytask object
     * and a personal user weeklyquiz object
     *
     * @param $user
     * @param $datetime
     * @return bool
     */
    public function create($user, $datetime)
    {
        $codegenerator = $this->container->get('codegenerator');
        if (($weeklytask = $this->container->get('weeklytask')->choose($user))) {

            $weeklytaskUser = new WeeklytaskUser();
            $weeklytaskUser->setDone(0);
            $weeklytaskUser->setProcessed(0);
            $weeklytaskUser->setUser($user);
            $weeklytaskUser->setDate($datetime);
            $weeklytaskUser->setTask($weeklytask);
            $weeklytaskUser->setCode($codegenerator->password(10));
            $weeklytaskUser->setCountPoint(0);

            $this->container->get('entity_manager')->persist($weeklytaskUser);
            $this->container->get('entity_manager')->flush($weeklytaskUser);

            // if a quiz for weeklytask exists
            // create reminder for weeklyquiz
            if (($quiz = $weeklytask->getQuiz())) {

                $weeklyquizUser = new WeeklyquizUser();
                $weeklyquizUser->setDone(0);
                $weeklyquizUser->setProcessed(0);
                $weeklyquizUser->setQuiz($quiz);
                $weeklyquizUser->setUser($user);
                $weeklyquizUser->setCountPoint(0);
                $weeklyquizUser->setCode($codegenerator->password(10));
                $weeklyquizUser->setTask($weeklytask);
                $weeklyquizUser->setDate($datetime->modify('+1 day'));
                $weeklyquizUser->setUserTask($weeklytaskUser);

                $this->container->get('entity_manager')->persist($weeklyquizUser);
                $this->container->get('entity_manager')->flush($weeklyquizUser);

                $weeklytaskUser->setUserQuiz($weeklyquizUser);
                $this->container->get('entity_manager')->persist($weeklytaskUser);
                $this->container->get('entity_manager')->flush($weeklytaskUser);
            }

            return true;
        }
        return false;
    }

    /**
     * Find last weeklytask user object
     * @param $user
     * @return mixed
     */
    public function getLast($user)
    {
        $entityManager = $this->container->get('entity_manager');
        $repositoryWeeklytaskUser = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser');

        return $repositoryWeeklytaskUser->findOneLast($user);
    }

    /**
     * Check is weeklytask last for this user
     * @param $user
     * @return bool
     */
    public function isLast($user, $datetime = null)
    {
        $entityManager = $this->container->get('entity_manager');
        $repositoryWeeklytask = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask');
        $repositoryWeeklytaskUser = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser');

        // Check if count of exercises in all categories
        // equals or smaller as sent to user
        if (($collectionWeeklytask = $repositoryWeeklytask->findAllByUserFocus($user->getFocus()))) {
            $collectionWeeklytask = new ArrayCollection($collectionWeeklytask);

            if (($collectionWeeklytaskUser = $repositoryWeeklytaskUser->findAllByUserFocus($user->getFocus()))) {
                $collectionWeeklytaskUser = new ArrayCollection($collectionWeeklytaskUser);
                // For each accessible weeklytasks
                // check is user has all tasks viewed
                return $collectionWeeklytask->forAll(function ($key, $weeklytask) use ($collectionWeeklytaskUser) {
                    // Search for each weeklytasks in personal user
                    // weeklytask log
                    return $collectionWeeklytaskUser->filter(function ($weeklytaskUser) use ($weeklytask) {
                        return $weeklytaskUser->getTask()->getId() == $weeklytask->getId();
                    })->count() > 0;
                });
            }
        }

        return false;
    }

    /**
     * Check is weeklytask exists for user and datetime
     * @param $user
     * @param $datetime
     * @return bool
     */
    public function isExists($user, $datetime)
    {
        $entityManager = $this->container->get('entity_manager');
        $repositoryWeeklytaskUser = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser');

        return $repositoryWeeklytaskUser->findOneByUserAndDateTime($user, $datetime);
    }

    /**
     * Choose weeklytask to send
     *
     * @param $user
     * @return array|null
     */
    public function choose($user)
    {
        $chooserCategory = $this->container->get('chooser_category');
        if (($categories = $chooserCategory->choose($user->getFocus()))) {

            $entityManager = $this->container->get('entity_manager');
            $repositoryWeeklytaskUser = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser');

            $existed = array();
            if (($collection = $repositoryWeeklytaskUser->findAllByUser($user))) {
                $collection = new ArrayCollection($collection);
                $existed = $collection->map(function ($entity) {
                    if (($task = $entity->getTask())) {
                        return $task->getId();
                    }
                    return null;
                })->toArray();
            }

            return (new ChooserWeeklytask())->choose($categories, $existed);
        }

        return null;
    }


    /**
     * TODO: check usage
     *
     * @param $datetime
     * @return mixed
     */
    public function toSend($datetime)
    {
        $entityManager = $this->container->get('entity_manager');
        $repositoryWeeklytaskUser = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser');
        return $repositoryWeeklytaskUser->findAllNotProcessedByDateTime($datetime);
    }

    /**
     * TODO: check usage
     *
     * Get nex weekly task with respect to category, priority
     * and already done tasks
     * @param $user
     * @param $focus
     * @return mixed
     */
    public function next($user = null, $datetime = null)
    {
        $entityManager = $this->container->get('entity_manager');
        $repositoryWeeklytaskUser = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser');
        if (!$repositoryWeeklytaskUser->findOneByUserAndDateTime($user, $datetime)) {

            // if user has no company
            // show subcategories from focus
            if (($company = $user->getCompany())) {
                if (($focus = $user->getFocus())) {

                    // Check is focus assigned to user company
                    // TODO: user have to contact administrator here
                    $repositoryCompanyCategory = $entityManager->getRepository('Fitbase\Bundle\CompanyBundle\Entity\CompanyCategory');
                    if (($repositoryCompanyCategory->findOneByCompanyAndCategory($company, $focus))) {

                        // TODO: refactoring to reduce sql queries
                        $repositoryWeeklytask = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask');
                        if (($collection = $repositoryWeeklytask->findAllByCategoryAndPriority($focus))) {
                            foreach ($collection as $weeklytask) {
                                if (!$repositoryWeeklytaskUser->findOneByUserAndTask($user, $weeklytask)) {
                                    return $weeklytask;
                                }
                            }
                        }
                    }
                }
            }
        }
        return null;
    }

    /**
     * TODO: check usage
     *
     * Get first start date
     * @param $user
     * @return int
     */
    public function getUserFirstDate($user)
    {
        $date = $user->getRegistered();
        $date->setTimezone(
            $this->container->get('datetime')
                ->getDateTimeZone()
        );

        $date->modify("midnight next monday");
        $date->setTime(0, 0, 0);

        return $date;
    }

    /**
     * TODO: check usage
     *
     * Get user next date
     * @param $user
     * @return \DateTime
     */
    public function getUserNextDate($user)
    {
        $datetime = $this->container
            ->get('datetime');

        $date = $datetime->getDateTime('now');
        $date->modify("midnight next monday");
        $date->setTime(0, 0, 0);

        return $date;
    }


    /**
     * TODO: check usage
     *
     * Get date using a post with position
     * @param $user
     * @param $post
     * @return string
     */
    public function getPostNextDate($user, $post)
    {
        if (!empty($post)) {
            $interval = 7 * 24 * 60 * 60 * (int)$post->getMetaValue('week');
            return $this->getUserFirstDate($user)->modify("+ $interval seconds");
        }
        return null;
    }
}