<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 21/03/15
 * Time: 10:15
 */

namespace Fitbase\Bundle\EmailBundle\Mailer\Patcher;

use Application\Sonata\UserBundle\Entity\User;

class PatcherUserCompanyImageAttach extends PatcherImageAttach
{
    protected $company;

    public function __construct($company, $logger)
    {
        $this->company = $company;

        parent::__construct(null, null, $logger);
    }

    /**
     * Patch a message for some user
     *
     * @param User $user
     * @param \Swift_Message $message
     * @return mixed
     */
    public function patch(User $user = null, \Swift_Message $message)
    {
        if (($company = $this->company->current($user))) {
            if (($site = $company->getSite())) {
                $this->host = $site->getHost();
                $this->scheme = $site->getScheme();
            }
        }

        return parent::patch($user, $message);
    }
}