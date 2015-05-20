<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 20/05/15
 * Time: 15:54
 */


namespace Fitbase\Bundle\FitbaseBundle\Library\Interfaces;

interface ServiceUserInterface
{
    /**
     * Method to get current system user
     * @return mixed
     */
    public function current();

    /**
     * Method to get admin user objects
     * @return mixed
     */
    public function getAdmins();

    /**
     * Method to get user objects ready to remove
     * @return mixed
     */
    public function getUsersToRemove();

    /**
     * Method to check is user have some of given roles
     * @param $user
     * @param null $roles
     * @return mixed
     */
    public function isGranted($user, $roles = null);


}