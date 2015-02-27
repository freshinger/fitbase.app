<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 06/01/15
 * Time: 16:11
 */

namespace Fitbase\Bundle\FitbaseBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class UserWizardEvent extends Event
{
    protected $entity;
    protected $response;

    public function __construct($entity)
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

    /**
     * @param mixed $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param mixed $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
        return $this;
    }


}