<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/10/14
 * Time: 1:09 AM
 */

namespace Fitbase\Bundle\FitbaseBundle\Service;


use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ServiceDatetime extends \DateTime implements ContainerAwareInterface
{
    protected $container;

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Get date time with timezone
     * @param null $date
     * @return \DateTime
     */
    public function getDateTime($date = null)
    {
        if ($date instanceof \DateTime) {
//            if (($timezone = $this->getDateTimeZone())) {
//                $date->setTimezone($timezone);
//            }
            return $date;
        }

        $datetime = new \DateTime($date);
//        if (($timezone = $this->getDateTimeZone())) {
//            $datetime->setTimezone($timezone);
//        }
        return $datetime;
    }
}