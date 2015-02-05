<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 05/02/15
 * Time: 12:27
 */

namespace Fitbase\Bundle\ExerciseBundle\Entity;


interface ExerciseManagerInterface
{
    /**
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @param null $unique
     * @return mixed
     */
    public function findOneById(\Application\Sonata\UserBundle\Entity\User $user = null, $unique = null);

} 