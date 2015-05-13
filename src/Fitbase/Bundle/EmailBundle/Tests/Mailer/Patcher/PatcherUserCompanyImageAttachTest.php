<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 05/02/15
 * Time: 15:45
 */

namespace Fitbase\Bundle\EmailBundle\Tests\Mailer\Patcher;


use Application\Sonata\PageBundle\Entity\Site;
use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\CompanyBundle\Entity\Company;
use Fitbase\Bundle\EmailBundle\Mailer\Patcher\PatcherLinkCode;
use Fitbase\Bundle\EmailBundle\Mailer\Patcher\PatcherUserCompanyImageAttach;
use Fitbase\Bundle\FitbaseBundle\Tests\FitbaseTestAbstract;
use ReflectionClass;
use ReflectionMethod;

class PatcherUserCompanyImageAttachTest extends FitbaseTestAbstract
{

    /**
     * Setup site object for current test
     * @return Site
     */
    protected function getSite()
    {
        $site = new Site();
        $site->setHost('app.fitbase.de');
        $site->setScheme('https');
        return $site;
    }

    /**
     * Get company service for current class
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getCompany()
    {
        $helper = $this->getMock('ServiceCompany', array('current'));
        $helper->expects($this->any())
            ->method('current')
            ->will($this->returnCallback(function ($user) {
                return (new Company())
                    ->addUser($user)
                    ->setSite($this->getSite());
            }));
        return $helper;
    }

    /**
     * Setup logger object for current test
     * @return object
     */
    protected function getLogger()
    {
        return $this->container()->get('logger');
    }


    public function testPatcherShouldConvertRelativeLinksToAbsoluteAndPatch()
    {
        $message = \Swift_Message::newInstance();
        $message->setBody('<a href="/test/test1">Link 1</a>');

        $patcher = new PatcherUserCompanyImageAttach($this->getCompany(), $this->getLogger());
        $patcher->patch(new User(), $message);


        $method = new ReflectionMethod($patcher, 'patchSrc');
        $method->setAccessible(true);

        $link = $method->invoke($patcher, new User(), '/test/test1');

        $this->assertNotFalse(strpos($link, 'https'));
        $this->assertNotFalse(strpos($link, 'app.fitbase.de'));
    }

    public function testPatcherShouldNotPatchAnotherHosts()
    {
        $message = \Swift_Message::newInstance();
        $message->setBody('<a href="https://wellbeing.fitbase.de/test/test1">Link 1</a>');

        $patcher = new PatcherUserCompanyImageAttach($this->getCompany(), $this->getLogger());
        $patcher->patch(new User(), $message);

        $method = new ReflectionMethod($patcher, 'patchSrc');
        $method->setAccessible(true);

        $link = $method->invoke($patcher, new User(), 'https://wellbeing.fitbase.de/test/test1');

        $this->assertNotFalse(strpos($link, 'https'));
        $this->assertNotFalse(strpos($link, 'wellbeing.fitbase.de'));
    }

} 