<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/11/14
 * Time: 11:19 AM
 */

namespace Fitbase\Bundle\GamificationBundle\Repository;


use Doctrine\ORM\EntityRepository;

class GamificationUserDialogFeedbackRepository extends EntityRepository
{
    /**
     * find records by positive
     * @param $queryBuilder
     * @return mixed
     */
    public function getExprPositive($queryBuilder)
    {
        $queryBuilder->setParameter('positive', 1);
        return $queryBuilder->expr()->eq('GamificationDialogQuestion.positive', ':positive');
    }

    /**
     * Get expression to find record by user id
     * @param $queryBuilder
     * @param $userId
     * @return mixed
     */
    public function getExprUserId($queryBuilder, $userId)
    {
        if (!empty($userId)) {

            $queryBuilder->setParameter('userId', $userId);
            return $queryBuilder->expr()->eq('GamificationUserDialogFeedback.user', ':userId');
        }

        return $queryBuilder->expr()->eq('0', '1');
    }

    /**
     * @param $user
     * @return mixed
     */
    public function findTextRandomByUserAndPositive($user)
    {
        $sql = "SELECT ors_gamification_user_dialog_feedback.text as text
                  FROM ors_gamification_user_dialog_feedback
                  JOIN ors_gamification_dialog_question ON ors_gamification_dialog_question.id=ors_gamification_user_dialog_feedback.question_id
                  WHERE ors_gamification_user_dialog_feedback.user_id=:user
                  AND ors_gamification_dialog_question.positive=:positive
                  ORDER BY RAND()
                  LIMIT 1";

        $query = $this->getEntityManager()
            ->getConnection()
            ->prepare($sql);

        $query->execute(array(
            'user' => $user->getId(),
            'positive' => 1
        ));

        if (($result = $query->fetch())) {
            return array_shift($result);
        }

        return null;
    }
}