<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 13/05/15
 * Time: 13:37
 */

namespace Fitbase\Bundle\FitbaseBundle\Tests\Library\Templating\Extension;


use Application\Sonata\PageBundle\Entity\Site;
use Fitbase\Bundle\CompanyBundle\Entity\Company;
use Fitbase\Bundle\FitbaseBundle\Library\Templating\Extension\FitbaseRoutingExtension;
use Fitbase\Bundle\FitbaseBundle\Tests\FitbaseTestAbstract;

class FitbaseRoutingExtensionTest extends FitbaseTestAbstract
{
    /**
     * Get generator mock for current test
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getGenerator()
    {
        return $this->getMock('Symfony\Component\Routing\Generator\UrlGeneratorInterface',
            array('generate', 'setContext', 'getContext'));
    }

    /**
     * Get generator context mock object
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getGeneratorContext()
    {
        return $this->getMock('Symfony\Component\Routing\RequestContext',
            array('getBaseUrl', 'getScheme', 'getHost', 'setBaseUrl', 'setScheme', 'setHost'));
    }


    /**
     * Setup site object for current test
     * @return Site
     */
    protected function getSite()
    {
        $site = new Site();
        $site->setScheme('https');
        $site->setHost('app.fitbase.de');
        $site->setRelativePath('/');

        return $site;
    }

    /**
     * Setup Company object for current test
     * @return $this
     */
    protected function getCompany()
    {
        return (new Company())
            ->setSite($this->getSite());
    }


    /**
     * Test that extension use a generator
     * and create correct link
     * @throws \Twig_Error_Runtime
     */
    public function testMethodGetUrlShouldGenerateUrl()
    {
        $route = null;

        $generator = $this->getGenerator();
        $generator->expects($this->any())
            ->method('generate')
            ->will($this->returnCallback(function ($name, $parameters, $type) use (&$route) {
                $route = $name;
            }));

        (new FitbaseRoutingExtension($generator))
            ->getUrlCompany($this->getCompany(), 'dashboard');

        $this->assertEquals($route, 'dashboard');
    }

    /**
     * @throws \Twig_Error_Runtime
     */
    public function testMethodGetUrlShouldChangeRequestContext()
    {
        $generatorContext = $this->getGeneratorContext();

        $generatorContext->expects($this->any())
            ->method('getBaseUrl')
            ->will($this->returnValue(null));

        $currentUrl = null;
        $generatorContext->expects($this->any())
            ->method('setBaseUrl')
            ->will($this->returnCallback(function ($url) use (&$currentUrl) {
                $currentUrl = $url;
            }));

        $generatorContext->expects($this->any())
            ->method('getScheme')
            ->will($this->returnValue(null));

        $currentScheme = null;
        $generatorContext->expects($this->any())
            ->method('setScheme')
            ->will($this->returnCallback(function ($scheme) use (&$currentScheme) {
                $currentScheme = $scheme;
            }));

        $generatorContext->expects($this->any())
            ->method('getHost')
            ->will($this->returnValue(null));

        $currentHost = null;
        $generatorContext->expects($this->any())
            ->method('setHost')
            ->will($this->returnCallback(function ($host) use (&$currentHost) {
                $currentHost = $host;
            }));

        $generator = $this->getGenerator();
        $generator->expects($this->any())
            ->method('getContext')
            ->will($this->returnValue($generatorContext));


        (new FitbaseRoutingExtension($generator))
            ->getUrlCompany($this->getCompany(), 'dashboard');


        $this->assertNotEmpty($currentUrl);
        $this->assertNotEmpty($currentHost);
        $this->assertNotEmpty($currentScheme);
    }

    /**
     * Check that company object is required
     *
     */
    public function testMethodGetUrlShouldThrowExceptionWithoutCompany()
    {
        $exception = null;

        try {

            (new FitbaseRoutingExtension($this->getGenerator()))
                ->getUrlCompany(null, 'dashboard');

        } catch (\Exception $exception) {

        }

        $this->assertNotEmpty($exception);
    }


} 