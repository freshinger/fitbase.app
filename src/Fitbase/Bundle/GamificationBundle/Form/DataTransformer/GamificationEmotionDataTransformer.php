<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/2/14
 * Time: 10:22 AM
 */

namespace Fitbase\Bundle\GamificationBundle\Form\DataTransformer;


use Symfony\Component\Form\DataTransformerInterface;

class GamificationEmotionDataTransformer implements DataTransformerInterface
{
    protected $association = array(
        1 => -2,
        2 => -1,
        3 => 0,
        4 => 1,
        5 => 1,
    );

    /**
     * Transform from entity id to html
     * @param mixed $value
     * @return mixed|null
     */
    public function transform($value)
    {
        return array_search($value, $this->association);
    }

    /**
     * Transform from html to entity id
     * @param mixed $value
     * @return mixed|null
     */
    public function reverseTransform($value)
    {
        if (isset($this->association[$value])) {
            return $this->association[$value];
        }
        return null;
    }
}