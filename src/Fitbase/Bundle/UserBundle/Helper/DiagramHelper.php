<?php
namespace Fitbase\Bundle\UserBundle\Helper;

use Symfony\Component\DependencyInjection\ContainerInterface;

class DiagramHelper extends \Fitbase\Bundle\FitbaseBundle\Helper\DiagramHelper
{

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('pie_user', array($this, 'getPieUser')),
            new \Twig_SimpleFunction('pie_focus', array($this, 'getPieFocus')),
        );
    }

    /**
     * @param $data
     * @param null $name
     * @return null|string
     */
    public function getPieUser($data, $name = null)
    {
        return $this->pie($name, $data);
    }

    /**
     * @param $data
     * @param null $name
     * @return null|string
     */
    public function getPieFocus($data, $name = null)
    {
        return $this->pie($name, $data);
    }


    public function getName()
    {
        return 'fitbase_diagram_user_extension';
    }
}