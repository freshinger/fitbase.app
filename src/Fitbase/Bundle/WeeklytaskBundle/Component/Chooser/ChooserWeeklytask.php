<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Component\Chooser;

class ChooserWeeklytask implements ChooserInterface
{
    /**
     * Process user focus and get a categories list
     * @return array
     */
    public function choose(array $categories = array(), array $existed = array())
    {
        foreach ($categories as $category) {
            if (($weeklytasks = $category->getWeeklytasks())) {
                foreach ($weeklytasks as $weeklytask) {
                    if (!in_array($weeklytask->getId(), $existed)) {
                        return $weeklytask;
                    }
                }
            }
        }
        return null;
    }
}