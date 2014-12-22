<?php

namespace Fitbase\Bundle\WeeklytaskBundle\Component\Chooser;


interface ChooserInterface
{
    /**
     * Process user focus and get a categories list
     * @return array
     */
    public function choose($categories = array(), array $result = array());

} 