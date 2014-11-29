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
        $message->setFrom(array('alex@fitbase.de' => 'alex'));
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
            foreach ($images as $pathRaw => $data) {
                $content = str_replace($pathRaw, 'data:image/png;base64,' . base64_encode($data), $content);
            }
            $message->setBody($content);
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
                $pathRaw = pq($image)->attr('src');
                $pathMod = pq($image)->attr('src');
                if (strpos($pathMod, 'http') === false) {
                    $pathMod = $this->container->get('kernel')->getRootDir() . "/../web$pathMod";
                }
                $srcImages[$pathRaw] = file_get_contents($pathMod);
            }
        }

        return $srcImages;
    }
}