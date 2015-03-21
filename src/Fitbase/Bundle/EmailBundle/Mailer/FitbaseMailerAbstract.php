<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 8/11/14
 * Time: 11:19 AM
 */

namespace Fitbase\Bundle\EmailBundle\Mailer;


use Fitbase\Bundle\EmailBundle\Mailer\Patcher\SwiftMessagePatcherInterface;
use FOS\UserBundle\Model\UserInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

abstract class FitbaseMailerAbstract extends ContainerAware
{
    /**
     * Store mailer service here
     * @var
     */
    protected $mailer;
    protected $kernel;
    protected $logger;
    protected $patchers;

    /**
     * Class constructor
     * @param \Swift_Mailer $mailer
     */
    public function __construct($kernel, \Swift_Mailer $mailer, LoggerInterface $logger)
    {
        $this->mailer = $mailer;
        $this->kernel = $kernel;
        $this->logger = $logger;
        $this->patchers = array();
    }

    /**
     * Add swift message patcher to collection
     * @param SwiftMessagePatcherInterface $patcher
     */
    public function addPatcher(SwiftMessagePatcherInterface $patcher)
    {
        array_push($this->patchers, $patcher);
    }

    /**
     * Create mail and send
     * @param $user
     * @param $title
     * @param $content
     */
    public function mail(UserInterface $user, $title, $content, $from = array('info@fitbase.de' => 'Fitbase'))
    {
        $message = \Swift_Message::newInstance();
        $message->setTo($user->getEmail());
        $message->setFrom($from);
        $message->setSubject($title);
        $message->setContentType("text/html");
        $message->setBody($content);

        $patched = true;
        if (count($this->patchers)) {
            foreach ($this->patchers as $patcher) {
                if (!$patcher->patch($user, $message)) {
                    $patched = false;
                }
            }
        }

        // Check if all patches was
        // a correct, than send a message
        if ($patched) {
            $this->mailer->send($message);
        }
    }
}