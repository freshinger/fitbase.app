<?php
namespace Fitbase\Bundle\FitbaseBundle\Helper;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DiagramHelper extends \Twig_Extension
{
    protected $graph;

    public function __construct($graph)
    {
        $this->graph = $graph;
    }

    /**
     * Build a pie diagram
     *
     * @param $name
     * @param $data
     * @return null|string
     */
    public function pie($name, $data)
    {
        if (($graph = $this->graph->pie($name, $data))) {
            ob_start();
            $graph->img->Stream();
            $image = ob_get_contents();
            ob_end_clean();
            return '<img style="width: 100%;" src="data:image/png;base64,' . base64_encode($image) . '"  />';
        }

        return null;
    }


    public function bar($name, $data)
    {
        if (($graph = $this->graph->bar($name, $data))) {
            ob_start();
            $graph->img->Stream();
            $image = ob_get_contents();
            ob_end_clean();
            return '<img style="width: 100%;" src="data:image/png;base64,' . base64_encode($image) . '"  />';
        }

        return null;
    }


    public function getName()
    {
        return 'fitbase_diagram_extension';
    }
}