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
    protected $cache = array(
        'anger' => -2,
        'sad' => -1,
        'normal' => 0,
        'gut' => 1,
        'happy' => 2,
    );

    /**
     * Transform from entity id to html
     * @param mixed $value
     * @return mixed|null
     */
    public function transform($value)
    {
        return array_search($value, $this->cache);
    }

    /**
     * Transform from html to entity id
     * @param mixed $value
     * @return mixed|null
     */
    public function reverseTransform($value)
    {
        if (isset($this->cache[$value])) {
            return $this->cache[$value];
        }
        return null;
    }
}