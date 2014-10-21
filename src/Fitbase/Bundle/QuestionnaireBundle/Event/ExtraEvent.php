<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/17/14
 * Time: 3:49 PM
 */

namespace Fitbase\Bundle\QuestionnaireBundle\Event;


use Fitbase\Bundle\QuestionnaireBundle\Entity\Extra;
use Symfony\Component\EventDispatcher\Event;

class ExtraEvent extends Event
{
    protected $entity;

    public function __construct(Extra $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @param mixed $entity
     */
    public function setEntity(Extra $entity)
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