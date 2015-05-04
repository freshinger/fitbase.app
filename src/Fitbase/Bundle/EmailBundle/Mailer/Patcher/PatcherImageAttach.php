<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 21/03/15
 * Time: 10:15
 */

namespace Fitbase\Bundle\EmailBundle\Mailer\Patcher;

use Application\Sonata\UserBundle\Entity\User;

class PatcherImageAttach implements SwiftMessagePatcherInterface
{

    protected $host;
    protected $scheme;
    protected $logger;

    public function __construct($scheme, $host, $logger)
    {
        $this->host = $host;
        $this->scheme = $scheme;
        $this->logger = $logger;
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
        \phpQuery::newDocumentHTML($message->getBody());

        $images = pq('img');
        if ($images->count()) {
            foreach ($images as $image) {
                if (($src = pq($image)->attr('src'))) {
                    if (($path = $this->patchSrc($user, $src))) {

                        try {
                            if (($embed = $message->embed(\Swift_Image::fromPath($path)))) {
                                pq($image)->attr('src', $embed);
                            }
                        } catch (\Exception $ex) {
                            $this->logger->crit($ex->getMessage());
                            continue;
                        }

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
     * Patch src to get a full link to download
     *
     * @param $user
     * @param $src
     * @return null
     */
    protected function patchSrc(User $user = null, $src)
    {
        if (($parts = parse_url($src))) {
            if (!array_key_exists('scheme', $parts)) {
                $parts['scheme'] = $this->scheme;
            }
            if (!array_key_exists('host', $parts)) {
                $parts['host'] = $this->host;
            }
            return http_build_url(null, $parts);
        }

        return null;
    }
}