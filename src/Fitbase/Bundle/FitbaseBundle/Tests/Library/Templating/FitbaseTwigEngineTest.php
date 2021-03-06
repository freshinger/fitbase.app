<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 11/05/15
 * Time: 11:42
 */


namespace Fitbase\Bundle\FitbaseBundle\Tests\Library\Templating;

use Fitbase\Bundle\FitbaseBundle\Library\Templating\FitbaseTwigEngine;
use Fitbase\Bundle\FitbaseBundle\Tests\FitbaseTestAbstract;


class FitbaseTwigEngineTest extends FitbaseTestAbstract
{
    protected $engine;
    protected $deviceDetector;

    public function setUp()
    {
        $environment = $this->getMock('\Twig_Environment', array());
        $parser = $this->getMock('Symfony\Component\Templating\TemplateNameParserInterface', array());
        $locator = $this->getMock('Symfony\Component\Config\FileLocatorInterface', array());
        $this->deviceDetector = $this->getMock('Fitbase\Bundle\FitbaseBundle\Library\Detector\DeviceDetectorInterface',
            array('isDesktop', 'isTablet', 'isMobile'));

        $this->engine = new FitbaseTwigEngine($environment, $parser, $locator, $this->deviceDetector);
    }

    public function testMethodPatchShouldReturnMobileTemplateName()
    {
        $this->deviceDetector->expects($this->any())
            ->method('isMobile')
            ->will($this->returnValue(true));

        $this->deviceDetector->expects($this->any())
            ->method('isTablet')
            ->will($this->returnValue(false));

        $this->deviceDetector->expects($this->any())
            ->method('isDesktop')
            ->will($this->returnValue(false));

        $this->assertEquals($this->engine->patch("layout.html.twig"), "Mobile/layout.html.twig");
    }


    public function testMethodPatchShouldReturnTableTemplateName()
    {
        $this->deviceDetector->expects($this->any())
            ->method('isMobile')
            ->will($this->returnValue(false));

        $this->deviceDetector->expects($this->any())
            ->method('isTablet')
            ->will($this->returnValue(true));

        $this->deviceDetector->expects($this->any())
            ->method('isDesktop')
            ->will($this->returnValue(false));

        $this->assertEquals($this->engine->patch("layout.html.twig"), "Tablet/layout.html.twig");
    }


    public function testMethodPatchShouldReturnNull()
    {
        $this->deviceDetector->expects($this->any())
            ->method('isMobile')
            ->will($this->returnValue(false));

        $this->deviceDetector->expects($this->any())
            ->method('isTablet')
            ->will($this->returnValue(false));

        $this->deviceDetector->expects($this->any())
            ->method('isDesktop')
            ->will($this->returnValue(true));

        $this->assertEquals($this->engine->patch("layout.html.twig"), null);
    }
}