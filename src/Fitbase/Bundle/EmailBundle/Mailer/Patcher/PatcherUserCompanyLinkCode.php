<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 21/03/15
 * Time: 10:15
 */

namespace Fitbase\Bundle\EmailBundle\Mailer\Patcher;

use Application\Sonata\UserBundle\Entity\User;

class PatcherUserCompanyLinkCode extends PatcherLinkCode
{
    protected $company;

    /**
     * Class constructor
     * @param $helper
     */
    public function __construct($company, $helper)
    {
        $this->company = $company;
        parent::__construct(null, null, $helper);
    }

    /**
     * Change message content
     *
     * @param User $user
     * @param \Swift_Message $message
     * @return mixed|void
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