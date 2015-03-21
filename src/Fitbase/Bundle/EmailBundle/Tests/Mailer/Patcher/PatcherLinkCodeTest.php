<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 05/02/15
 * Time: 15:45
 */

namespace Fitbase\Bundle\EmailBundle\Tests\Mailer\Patcher;


use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\EmailBundle\Mailer\Patcher\PatcherLinkCode;
use Fitbase\Bundle\FitbaseBundle\Tests\FitbaseTestAbstract;

class PatcherLinkCodeTest extends FitbaseTestAbstract
{
    protected $helper;

    public function setUp()
    {
        $this->helper = $this->getMock('SignOnHelper', array('getSign'));
        $this->helper->expects($this->any())
            ->method('getSign')
            ->will($this->returnCallback(function ($user, $link) {
                return "$link?signed";
            }));
    }

    public function testPatcherShouldPatchRelativeLinks()
    {
        $message = \Swift_Message::newInstance();
        $message->setBody('<a href="/test/test1">Link 1</a>');


        $patcher = new PatcherLinkCode('https', 'app.fitbase.de', $this->helper);
        $patcher->patch((new User()), $message);

        \phpQuery::newDocumentHTML($message->getBody());

        $this->assertNotFalse(strpos(pq(pq('a')->get(0))->attr('href'), '?signed'));
    }

    public function testPatcherShouldConvertRelativeLinksToAbsoluteAndPatch()
    {
        $message = \Swift_Message::newInstance();
        $message->setBody('<a href="/test/test1">Link 1</a>');


        $patcher = new PatcherLinkCode('https', 'app.fitbase.de', $this->helper);
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

        $patcher = new PatcherLinkCode('https', 'app.fitbase.de', $this->helper);
        $patcher->patch((new User()), $message);

        \phpQuery::newDocumentHTML($message->getBody());

        $this->assertNotFalse(strpos(pq(pq('a')->get(0))->attr('href'), '?signed'));
    }

    public function testPatcherShouldNotPatchAnotherHosts()
    {
        $message = \Swift_Message::newInstance();
        $message->setBody('<a href="https://app.fitbase.de/test/test1">Link 1</a>');

        $patcher = new PatcherLinkCode('https', 'app.test.de', $this->helper);
        $patcher->patch((new User()), $message);

        \phpQuery::newDocumentHTML($message->getBody());

        $this->assertFalse(strpos(pq(pq('a')->get(0))->attr('href'), '?signed'));
    }

} 