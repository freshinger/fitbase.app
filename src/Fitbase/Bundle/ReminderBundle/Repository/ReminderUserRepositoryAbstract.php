<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 8/11/14
 * Time: 2:15 PM
 */

namespace Fitbase\Bundle\ReminderBundle\Repository;


use Doctrine\ORM\EntityRepository;

class ReminderUserRepositoryAbstract extends EntityRepository
{
    /**
     * Get expr by pause not null or empty
     * @param $queryBuilder
     * @return mixed
     */
    protected function getExprPaused($queryBuilder)
    {
        $queryBuilder->setParameter(':pause', 1);
        return $queryBuilder->expr()->eq('ReminderUser.pause', ':pause');
    }

    /**
     * Expression to get items for enabled user only
     * @param $queryBuilder
     * @return mixed
     */
    protected function getExprUserEnabled($queryBuilder)
    {
        $queryBuilder->setParameter(':enabled', 1);
        return $queryBuilder->expr()->eq('User.enabled', ':enabled');
    }

    /**
     * @param $queryBuilder
     * @return mixed
     */
    protected function getExprUserNotExpired($queryBuilder)
    {
        $queryBuilder->setParameter(':expired', 0);
        return $queryBuilder->expr()->orx(
            $queryBuilder->expr()->isNull('User.expired'),
            $queryBuilder->expr()->eq('User.expired', ':expired')
        );
    }

    /**
     * @param $queryBuilder
     * @return mixed
     */
    protected function getExprUserNotLocked($queryBuilder)
    {
        $queryBuilder->setParameter(':locked', 0);
        return $queryBuilder->expr()->orx(
            $queryBuilder->expr()->isNull('User.locked'),
            $queryBuilder->expr()->eq('User.locked', ':locked')
        );
    }

    /**
     * Get expr for all not paused reminders
     * @param $queryBuilder
     * @return mixed
     */
    protected function getExprNotPaused($queryBuilder)
    {
        $queryBuilder->setParameter(':pause', 0);

        return $queryBuilder->expr()->andX(
            $queryBuilder->expr()->orx(
                $queryBuilder->expr()->isNull('ReminderUser.pause'),
                $queryBuilder->expr()->eq('ReminderUser.pause', ':pause')
            ),
            $this->getExprUserEnabled($queryBuilder),
            $this->getExprUserNotExpired($queryBuilder),
            $this->getExprUserNotLocked($queryBuilder)
        );
    }

    /**
     * Get all user-tasks
     * @param $queryBuilder
     * @param $user
     * @return mixed
     */
    protected function getExprUser($queryBuilder, $user)
    {
        if (!empty($user)) {

            $queryBuilder->setParameter('userId', $user->getId());

            return $queryBuilder->expr()->andx(
                $queryBuilder->expr()->eq('User.id', ':userId'),
                $this->getExprUserEnabled($queryBuilder),
                $this->getExprUserNotExpired($queryBuilder),
                $this->getExprUserNotLocked($queryBuilder)
            );
        }

        return $queryBuilder->expr()->eq('1', '0');
    }
}