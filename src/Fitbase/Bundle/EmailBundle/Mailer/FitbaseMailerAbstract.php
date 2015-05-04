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
     * Build a message
     * @param $email
     * @param $title
     * @param $content
     * @param array $from
     * @return \Swift_Mime_SimpleMimeEntity
     */
    protected function getMessage($email, $title, $content, $from = array('info@fitbase.de' => 'Fitbase'))
    {
        return \Swift_Message::newInstance()
            ->setTo($email)
            ->setFrom($from)
            ->setSubject($title)
            ->setContentType("text/html")
            ->setBody($content);
    }

    /**
     * Create mail and send
     * @param $email
     * @param $title
     * @param $content
     */
    /**
     * Add swift message patcher to collection
     * @param SwiftMessagePatcherInterface $patcher
     */
    public function addPatcher(SwiftMessagePatcherInterface $patcher)
    {
        array_push($this->patchers, $patcher);
    }

    /**
     * @param $user
     * @param $title
     * @param $content
     * @param array $from
     */
    public function mail(UserInterface $user, $title, $content, $from = array('info@fitbase.de' => 'Fitbase'))
    {
        if (($message = $this->getMessage($user->getEmail(), $title, $content, $from))) {

            if (count($this->patchers)) {
                foreach ($this->patchers as $patcher) {
                    if (!$patcher->patch($user, $message)) {
                        return false;
                    }
                }
            }

            // Check if all patches was
            // a correct, than send a message
            $this->mailer->send($message);
        }
    }
}