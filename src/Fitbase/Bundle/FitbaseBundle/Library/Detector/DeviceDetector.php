<?php

/**
 * File: Browser.php
 * Author: Chris Schuld (http://chrisschuld.com/)
 * Last Modified: July 4th, 2014
 * @version 1.9
 * @package PegasusPHP
 *
 * Copyright (C) 2008-2010 Chris Schuld  (chris@chrisschuld.com)
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 2 of
 * the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details at:
 * http://www.gnu.org/copyleft/gpl.html
 *
 *
 * Typical Usage:
 *
 *   $browser = new BrowserDetector();
 *   if( $browser->getBrowser() == Browser::BROWSER_FIREFOX && $browser->getVersion() >= 2 ) {
 *    echo 'You have FireFox version 2 or greater';
 *   }
 *
 * User Agents Sampled from: http://www.useragentstring.com/
 *
 * This implementation is based on the original work from Gary White
 * http://apptools.com/phptools/browser/
 *
 */
namespace Fitbase\Bundle\FitbaseBundle\Library\Detector;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DeviceDetector extends ContainerAware implements DeviceDetectorInterface
{
    protected $browserDetector;

    /**
     * Class constructor
     * @param BrowserDetector $browserDetector
     */
    public function __construct(BrowserDetector $browserDetector)
    {
        $this->browserDetector = $browserDetector;
    }

    /**
     * Set container
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);

        if (($request = $container->get('request'))) {
            $this->browserDetector->setUserAgent($request->headers->get('User-Agent'));
        }
    }


    /**
     * Check is a desktop computer
     * @return bool
     */
    public function isDesktop()
    {
        return (!$this->browserDetector->isMobile() and !$this->browserDetector->isTablet());
    }

    /**
     * Check is device a tablet computer
     * @return bool
     */
    public function isTablet()
    {
        return ($this->browserDetector->isTablet() and !$this->browserDetector->isMobile());
    }

    /**
     * Check is device a mobile computer
     * @return bool
     */
    public function isMobile()
    {
        return (!$this->browserDetector->isTablet() and $this->browserDetector->isMobile());
    }


}
