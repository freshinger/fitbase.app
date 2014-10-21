<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/2/14
 * Time: 10:22 AM
 */

namespace Fitbase\Bundle\QuestionnaireBundle\Form\DataTransformer;


use Symfony\Component\Form\DataTransformerInterface;

class QuestionnaireQuestionDataTransformerSlider implements DataTransformerInterface
{
    /**
     * Array with choices
     * @var array
     */
    protected $choices = array();

    /**
     * Array with answers
     * @var array
     */
    protected $answers = array();

    /**
     * Class constructor
     * @param $collection
     */
    public function __construct($collection)
    {
        foreach ($collection as $answer) {
            array_push($this->answers, $answer->getId());
            array_push($this->choices, $answer->getName());
        }
    }

    /**
     * Get choices
     * @return array
     */
    public function getChoices()
    {
        return $this->choices;
    }

    /**
     * Transform from entity id to html
     * @param mixed $value
     * @return mixed|null
     */
    public function transform($value)
    {
        if (($key = array_search($value, $this->answers))) {
            return $this->choices[$key];
        }
        return null;
    }

    /**
     * Transform from html to entity id
     * @param mixed $value
     * @return mixed|null
     */
    public function reverseTransform($value)
    {
        if (($key = array_search($value, $this->choices))) {
            return $this->answers[$key];
        }
        return null;
    }
}