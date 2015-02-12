<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 05/02/15
 * Time: 12:27
 */

namespace Fitbase\Bundle\WeeklytaskBundle\Entity;


interface WeeklytaskManagerInterface
{
    /**
     *
     * @param $user
     * @param $unique
     * @return mixed
     */
    public function findOneByUserAndUnique($user, $unique);

    /**
     * @param $user
     * @param $category
     * @return mixed
     */
    public function findAllByUserAndCategory($user, $category);

} 