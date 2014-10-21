<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/17/14
 * Time: 3:49 PM
 */

namespace Fitbase\Bundle\QuestionnaireBundle\Event;


use Fitbase\Bundle\QuestionnaireBundle\Entity\Password;
use Symfony\Component\EventDispatcher\Event;

class SectionEvent extends Event
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

}