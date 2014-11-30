<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 8/11/14
 * Time: 11:19 AM
 */

namespace Fitbase\Bundle\ReminderBundle\Service;


use Symfony\Component\DependencyInjection\ContainerAware;

class ServiceMailer extends ContainerAware
{
    /**
     * Create mail and send
     * @param $email
     * @param $title
     * @param $content
     */
    public function mail($email, $title, $content)
    {
        $message = \Swift_Message::newInstance();
        $message->setTo($email);
        $message->setFrom(array('info@fitbase.de' => 'Fitbase'));
        $message->setSubject($title);
        $message->setContentType("text/html");
        $message->setBody($content);

        if (($this->images($message, $content))) {
            $this->container->get('mailer')->send($message);
        }
    }

    /**
     * Replace content images to attaches
     * @param $message
     * @param $content
     * @return mixed
     */
    protected function images($message, $content)
    {
        $cids = array();
        if (($images = $this->sources($content))) {
            foreach ($images as $pathRaw => $pathFull) {
                if (($embed = $message->embed(\Swift_Image::fromPath($pathFull)))) {
                    array_push($cids, $embed);
                }
            }
            $message->setBody(str_replace(array_keys($images), $cids, $content));

            return true;
        }
        $message->setBody($content);
        return true;
    }


    /**
     * Extract images from content
     * @param $content
     * @return array
     */
    protected function sources($content)
    {
        $srcImages = array();

        \phpQuery::newDocumentHTML($content);

        $htmlImages = pq('img');
        if ($htmlImages->count()) {
            foreach ($htmlImages as $image) {
                if (($pathRaw = pq($image)->attr('src'))) {
                    $pathFull = $pathRaw;
                    if (strpos($pathFull, 'http') === false) {
                        $pathFull = $this->container->get('kernel')->getRootDir() . "/../web$pathFull";
                    }
                    $srcImages[$pathRaw] = $pathFull;
                }
            }
        }

        return $srcImages;
    }
}