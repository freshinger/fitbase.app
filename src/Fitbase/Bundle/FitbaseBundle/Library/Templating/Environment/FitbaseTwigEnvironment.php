<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 11/05/15
 * Time: 10:35
 */

namespace Fitbase\Bundle\FitbaseBundle\Library\Templating\Environment;


use Fitbase\Bundle\FitbaseBundle\Library\Detector\DeviceDetectorInterface;
use Twig_LoaderInterface;

class FitbaseTwigEnvironment extends \Twig_Environment
{
    protected $deviceDetector;

    /**
     * Override constructor, add device detector
     *
     * @param Twig_LoaderInterface $loader
     * @param array $options
     * @param DeviceDetectorInterface $deviceDetector
     */
    public function __construct(Twig_LoaderInterface $loader = null, $options = array(), DeviceDetectorInterface $deviceDetector)
    {
        parent::__construct($loader, $options);

        $this->deviceDetector = $deviceDetector;
    }

    /**
     * Override method to find device-specified templates
     * @param string $name
     * @param null $index
     * @return \Twig_TemplateInterface
     */
    public function loadTemplate($name, $index = null)
    {
        if (($patched = $this->patch($name)) !== null) {

            try {
                return parent::loadTemplate($patched, $index);
            } catch (\Twig_Error_Loader $ex) {
                // if templates not found
                // ignore this error
            }
        }

        return parent::loadTemplate($name, $index);
    }

    /**
     * Patch template file name
     * @param $name
     * @return null|string
     */
    public function patch($name)
    {
        $prefix = null;

        if (!$this->deviceDetector->isDesktop()) {
            if ($this->deviceDetector->isMobile()) {
                $prefix = "Mobile/";
            } else if ($this->deviceDetector->isTablet()) {
                $prefix = "Tablet/";
            }
        }

        if ($this->deviceDetector->isOld()) {
            $prefix = "Old/";
        }


        if ($prefix !== null) {
            $pos1 = 0;
            if (($pos1 = strrpos($name, ":")) or ($pos1 = strrpos($name, "/"))) {
                $pos1++;
            }
            return substr($name, 0, $pos1) . $prefix . substr($name, $pos1);
        }


        return null;
    }
} 