<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/12/14
 * Time: 12:40 PM
 */

namespace Fitbase\Bundle\StatisticBundle\Helper;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class GraphHelper extends \Twig_Extension implements ContainerAwareInterface
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

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('pie', array($this, 'pie')),
            new \Twig_SimpleFunction('column', array($this, 'column')),

        );
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('pie', array($this, 'pie')),
            new \Twig_SimpleFilter('column', array($this, 'column')),

        );
    }


    /**
     * Build a pie diagram
     * @param $data
     * @return mixed
     */
    public function pie($name = null, $data = null)
    {
        if (($graph = $this->container->get('graph')->pie($name, $data))) {
            //Start buffering
            ob_start();
            $graph->img->Stream();
            $image = ob_get_contents();
            ob_end_clean();
            return '<img src="data:image/png;base64,' . base64_encode($image) . '"  />';
        }

        return null;
    }


    public function column($data)
    {

    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'fitbase_statistic_graph';
    }
} 