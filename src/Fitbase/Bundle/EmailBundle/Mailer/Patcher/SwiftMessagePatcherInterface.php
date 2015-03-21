<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 21/03/15
 * Time: 10:16
 */

namespace Fitbase\Bundle\EmailBundle\Mailer\Patcher;


use Application\Sonata\UserBundle\Entity\User;

interface SwiftMessagePatcherInterface
{
    /**
     * Patch a message for some user
     *
     * @param User $user
     * @param \Swift_Message $message
     * @return mixed
     */
    public function patch(User $user, \Swift_Message $message);
}