<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 21/03/15
 * Time: 10:15
 */

namespace Fitbase\Bundle\EmailBundle\Mailer\Patcher;

use Application\Sonata\UserBundle\Entity\User;

class PatcherLinkCode implements SwiftMessagePatcherInterface
{
    protected $host;
    protected $scheme;
    protected $helper;

    /**
     * Class constructor
     * @param $helper
     */
    public function __construct($scheme, $host, $helper)
    {
        $this->host = $host;
        $this->scheme = $scheme;
        $this->helper = $helper;
    }

    /**
     * Change message content
     *
     * @param User $user
     * @param \Swift_Message $message
     * @return mixed|void
     */
    public function patch(User $user, \Swift_Message $message)
    {
        \phpQuery::newDocumentHTML($message->getBody());

        $links = pq('a');
        if ($links->count()) {
            foreach ($links as $link) {
                if (($href = pq($link)->attr('href'))) {
                    if (($hrefPatched = $this->patchHref($user, $href))) {
                        pq($link)->attr('href', $hrefPatched);
                    }

                }
            }
            $message->setBody(
                pq('')->html()
            );
        }
        return true;
    }

    /**
     * Patch href and return
     * @param $href
     * @return string
     */
    protected function patchHref($user, $href)
    {
        if (($parts = parse_url($href))) {
            if (!array_key_exists('scheme', $parts)) {
                $parts['scheme'] = $this->scheme;
            }
            if (!array_key_exists('host', $parts)) {
                $parts['host'] = $this->host;
            }

            if ($parts['host'] == $this->host) {
                return $this->helper->getSign(
                    $user, http_build_url($parts));
            }
        }

        return null;
    }

}