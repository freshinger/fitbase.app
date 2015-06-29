<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/11/14
 * Time: 11:23 AM
 */

namespace Fitbase\Bundle\GamificationBundle\Event;


use Fitbase\Bundle\GamificationBundle\Entity\GamificationUser;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Response;

class WidgetEvent extends Event
{
    protected $response;

    protected $parameters;

    public function __construct($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param $response
     * @return $this
     */
    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param $parameters
     * @return $this
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

}