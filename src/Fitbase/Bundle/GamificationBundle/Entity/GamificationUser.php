<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/17/14
 * Time: 10:29 AM
 */

namespace Fitbase\Bundle\GamificationBundle\Entity;


class GamificationUser
{
    protected $id;
    protected $user;
    protected $avatar;
    protected $tree;

    /**
     * @param mixed $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param mixed $tree
     */
    public function setTree($tree)
    {
        $this->tree = $tree;
    }

    /**
     * @return mixed
     */
    public function getTree()
    {
        return $this->tree;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }
}