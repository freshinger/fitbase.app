<?php
namespace Fitbase\Bundle\ReminderBundle\Helper;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class ReminderHelper extends \Twig_Extension implements ContainerAwareInterface
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
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('username', array($this, 'getUserName')),
            new \Twig_SimpleFilter('status', array($this, 'getStatus')),
            new \Twig_SimpleFilter('reminderStatusColor', array($this, 'getReminderStatusColor')),
            new \Twig_SimpleFilter('day', array($this, 'getDayName')),

        );
    }

    public function getDayName($id)
    {
        $datetime = $this->container->get('datetime');
        $last_sunday = $datetime->getDateTime('last Sunday');
        $last_sunday->modify('+' . $id . ' day');

        return $this->container->get('translator')->trans($last_sunday->format('l'));
    }

    /**
     * Get color-coding for reminder status
     * @param $processed
     * @return string
     */
    public function getReminderStatusColor($processed)
    {
        if ($processed) {
            return "#99FF99";
        }
        return "#FFFFCC";
    }


    /**
     * Get status
     * @param $processed
     * @return mixed
     */
    public function getStatus($processed)
    {
        if ($processed) {
            return $this->container->get('translator')->trans('versendet');
        }
        return $this->container->get('translator')->trans('nich versendet');
    }


    /**
     * Return user name from id
     * @param $id
     * @return mixed
     */
    public function getUserName($id)
    {
        if (($user = $this->container->get('fitbase_manager.user')->find($id))) {
            return $user->getDisplayName();
        }
        return $id;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'fitbase_reminder_extension';
    }
}