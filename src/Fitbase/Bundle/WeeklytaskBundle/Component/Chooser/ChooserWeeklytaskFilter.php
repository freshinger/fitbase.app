<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Component\Chooser;

class ChooserWeeklytaskFilter
{
    protected $filter;

    /**
     * Class constructor
     * @param callable $filter
     */
    public function __construct(\Closure $filter = null)
    {
        $this->filter = $filter;
    }

    /**
     * Process user focus and get a categories list
     * @return array
     */
    public function choose($categories = array(), array $result = array())
    {
        foreach ($categories as $category) {
            if (($weeklytasks = $category->getWeeklytasks())) {
                if (($weeklytask = $this->filter($weeklytasks, $this->filter))) {
                    if (!in_array($weeklytask, $result)) {
                        return $weeklytask;
                    }
                }
            }
        }

        return null;
    }

    /**
     * Get a exercise
     * @param callable $filter
     * @param $exercises
     * @return mixed
     */
    protected function filter($exercises, \Closure $filter = null)
    {
        foreach ($exercises as $index => $exercise) {
            if (!($filter instanceof \Closure)) {
                return $exercise;
            }

            if (call_user_func($filter, $exercise)) {
                return $exercise;
            }
        }

        return null;
    }
}