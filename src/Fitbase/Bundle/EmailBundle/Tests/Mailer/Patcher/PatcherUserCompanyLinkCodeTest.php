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
use Fitbase\Bundle\EmailBundle\Mailer\Patcher\PatcherUserCompanyLinkCode;
use Fitbase\Bundle\FitbaseBundle\Tests\FitbaseTestAbstract;

class PatcherUserCompanyLinkCodeTest extends FitbaseTestAbstract
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
     * Get helper for current class
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getHelper()
    {
        $helper = $this->getMock('SignOnHelper', array('getSign'));
        $helper->expects($this->any())
            ->method('getSign')
            ->will($this->returnCallback(function ($user, $link) {
                return "$link?signed";
            }));
        return $helper;
    }


    public function testPatcherShouldPatchRelativeLinks()
    {
        $message = \Swift_Message::newInstance();
        $message->setBody('<a href="/test/test1">Link 1</a>');


        $patcher = new PatcherUserCompanyLinkCode($this->getCompany(), $this->getHelper());
        $patcher->patch((new User()), $message);

        \phpQuery::newDocumentHTML($message->getBody());

        $this->assertNotFalse(strpos(pq(pq('a')->get(0))->attr('href'), '?signed'));
    }

    public function testPatcherShouldConvertRelativeLinksToAbsoluteAndPatch()
    {
        $message = \Swift_Message::newInstance();
        $message->setBody('<a href="/test/test1">Link 1</a>');


        $patcher = new PatcherUserCompanyLinkCode($this->getCompany(), $this->getHelper());
        $patcher->patch((new User()), $message);

        \phpQuery::newDocumentHTML($message->getBody());

        $this->assertNotFalse(strpos(pq(pq('a')->get(0))->attr('href'), '?signed'));
        $this->assertNotFalse(strpos(pq(pq('a')->get(0))->attr('href'), 'https'));
        $this->assertNotFalse(strpos(pq(pq('a')->get(0))->attr('href'), 'app.fitbase.de'));
    }

    public function testPatcherShouldPatchAbsoluteLinks()
    {
        $message = \Swift_Message::newInstance();
        $message->setBody('<a href="https://app.fitbase.de/test/test1">Link 1</a>');

        $patcher = new PatcherUserCompanyLinkCode($this->getCompany(), $this->getHelper());
        $patcher->patch((new User()), $message);

        \phpQuery::newDocumentHTML($message->getBody());

        $this->assertNotFalse(strpos(pq(pq('a')->get(0))->attr('href'), '?signed'));
    }


    public function testPatcherShouldNotPatchAnotherHosts()
    {
        $message = \Swift_Message::newInstance();
        $message->setBody('<a href="https://wellbeing.fitbase.de/test/test1">Link 1</a>');

        $patcher = new PatcherUserCompanyLinkCode($this->getCompany(), $this->getHelper());
        $patcher->patch((new User()), $message);

        \phpQuery::newDocumentHTML($message->getBody());

        $this->assertFalse(strpos(pq(pq('a')->get(0))->attr('href'), '?signed'));
    }

} 