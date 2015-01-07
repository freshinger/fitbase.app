<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 06/01/15
 * Time: 16:11
 */

namespace Fitbase\Bundle\FitbaseBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class UserMenuEvent extends Event
{
    protected $entity;

    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return mixed
     */
    public function getFactory()
    {
        return $this->factory;
    }

    public function getEntity()
    {
        return $this->entity;
    }
}