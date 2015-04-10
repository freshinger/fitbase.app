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
    protected $tree;


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

    /**
     * @var boolean
     */
    private $update;


    /**
     * Set update
     *
     * @param boolean $update
     * @return GamificationUser
     */
    public function setUpdate($update)
    {
        $this->update = $update;

        return $this;
    }

    /**
     * Get update
     *
     * @return boolean
     */
    public function getUpdate()
    {
        return $this->update;
    }

    /**
     * @var \Fitbase\Bundle\GamificationBundle\Entity\GamificationSettingsGalleryAvatar
     */
    private $avatar;


    /**
     * Set avatar
     *
     * @param \Fitbase\Bundle\GamificationBundle\Entity\GamificationSettingsGalleryAvatar $avatar
     * @return GamificationUser
     */
    public function setAvatar(\Fitbase\Bundle\GamificationBundle\Entity\GamificationSettingsGalleryAvatar $avatar = null)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return \Fitbase\Bundle\GamificationBundle\Entity\GamificationSettingsGalleryAvatar
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Get avatar media object
     *
     * @param null $date
     * @return null
     */
    public function getAvatarMedia($date = null)
    {
        if (($avatar = $this->getAvatar())) {
            if (($collection = $avatar->getGalleryHasMedia())) {
                foreach ($collection as $id => $hasMedia) {

                    if (($dateShow = $hasMedia->getShowAt())) {
                        if (($interval = $hasMedia->getinterval())) {

                            $dateShow->setDate(
                                $date->format('Y'),
                                $dateShow->format('m'),
                                $dateShow->format('d')
                            );

                            if ($dateShow <= $date) {
                                $dateShow->modify("+$interval week");
                                if ($dateShow >= $date) {
                                    return $hasMedia->getMedia();
                                }
                            }
                        }
                    }
                }

                foreach ($collection as $id => $hasMedia) {
                    if (!($dateShow = $hasMedia->getShowAt())) {
                        return $hasMedia->getMedia();
                    }
                }

            }
        }
        return null;
    }
}
