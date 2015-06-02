<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 02/06/15
 * Time: 15:34
 */

namespace Wellbeing\Bundle\StressBundle\Event;


use Symfony\Component\EventDispatcher\Event;
use Wellbeing\Bundle\StressBundle\Entity\UserStateStress;

class UserStateStressEvent extends Event
{
    protected $entity;

    public function __construct(UserStateStress $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return mixed
     */
    public function getEntity()
    {
        return $this->entity;
    }
} 