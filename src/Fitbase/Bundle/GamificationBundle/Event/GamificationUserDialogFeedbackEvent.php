<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/11/14
 * Time: 11:23 AM
 */

namespace Fitbase\Bundle\GamificationBundle\Event;


use Fitbase\Bundle\GamificationBundle\Entity\GamificationUserDialogAnswer;
use Fitbase\Bundle\GamificationBundle\Entity\GamificationUserDialogFeedback;
use Symfony\Component\EventDispatcher\Event;

class GamificationUserDialogFeedbackEvent extends Event
{
    protected $entity;


    public function __construct(GamificationUserDialogFeedback $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @param mixed $entity
     */
    public function setEntity(GamificationUserDialogFeedback $entity)
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