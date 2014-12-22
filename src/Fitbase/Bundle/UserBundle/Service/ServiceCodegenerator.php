<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 20/11/14
 * Time: 15:26
 */

namespace Fitbase\Bundle\UserBundle\Service;


use Symfony\Component\DependencyInjection\ContainerAware;

class ServiceCodegenerator extends ContainerAware
{
    /**
     * Generate secure password with requited length
     * @param int $length
     * @return string
     */
    public function password($length = 10)
    {
        $code = '';
        $string = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!?=_';
        for ($i = 0; $i < $length; $i++) {
            $code .= $string{rand(0, strlen($string) - 1)};
        }
        return $code;
    }

    /**
     * Generate code
     * @param int $length
     * @return string
     */
    public function code($length = 10)
    {
        $code = '';
        $string = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        for ($i = 0; $i < $length; $i++) {
            $code .= $string{rand(0, strlen($string) - 1)};
        }
        return $code;
    }
}