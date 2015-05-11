<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 11/05/15
 * Time: 10:35
 */

namespace Fitbase\Bundle\FitbaseBundle\Library\Templating;


use Fitbase\Bundle\FitbaseBundle\Library\Detector\DeviceDetectorInterface;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\Templating\TemplateNameParserInterface;

class FitbaseTwigEngine extends TwigEngine
{

    protected $deviceDetector;

    public function __construct(\Twig_Environment $environment, TemplateNameParserInterface $parser,
                                FileLocatorInterface $locator, DeviceDetectorInterface $deviceDetector)
    {
        parent::__construct($environment, $parser, $locator);

        $this->deviceDetector = $deviceDetector;
    }


    /**
     * Override method to change templates for desktop and mobile
     * @param string|\Symfony\Component\Templating\TemplateReferenceInterface|\Twig_Template $name
     * @return \Twig_TemplateInterface
     */
    protected function load($name)
    {
        if (($patched = $this->patch($name)) != null) {

            try {

                if ($name instanceof \Twig_Template) {
                    return $name;
                }

                return $this->environment->loadTemplate($patched);
            } catch (\Twig_Error_Loader $e) {
                // ignore errors if custom template not found
                // other errors has not to be catch
            }
        }

        return parent::load($name);
    }

    /**
     * Patch template name
     * @param $name
     * @return string
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