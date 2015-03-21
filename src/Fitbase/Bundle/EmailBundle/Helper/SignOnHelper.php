<?php
namespace Fitbase\Bundle\EmailBundle\Helper;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SignOnHelper extends \Twig_Extension
{
    protected $singlesignon;

    /**
     * Class constructor
     * @param $singlesignon
     */
    public function __construct($singlesignon)
    {
        $this->singlesignon = $singlesignon;
    }

    /**
     * Get extension functions associations
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('sign', array($this, 'getSign')),
        );
    }

    /**
     * Get Single sign on link
     * @param $user
     * @param $link
     * @return string
     */
    public function getSign($user, $link)
    {
        if (($code = $this->singlesignon->code($user))) {
            if (($query = parse_url($link))) {
                if (isset($query['query'])) {
                    return "$link&sign=$code";
                }
                return "$link?sign=$code";
            }
        }
        return $link;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'fitbase_signon_extension';
    }
}