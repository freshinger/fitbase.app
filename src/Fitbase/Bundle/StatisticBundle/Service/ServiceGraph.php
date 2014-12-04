<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 13/11/14
 * Time: 15:33
 */
namespace Fitbase\Bundle\StatisticBundle\Service;


use JpGraph\JpGraph;
use PieGraph;
use PiePlot;
use Symfony\Component\DependencyInjection\ContainerAware;

class ServiceGraph extends ContainerAware
{
    public function pie($name = null, $data = array(10, 10, 10, 10, 10, 10, 10, 10, 10, 10,))
    {
        if (!count($data)) {
            return null;
        }

        JpGraph::load();
        JpGraph::module('pie');

        $graph = new PieGraph(550, 520);
        $graph->SetShadow();

        $graph->title->Set($name);
        $p1 = new PiePlot(array_values($data));
        $p1->SetSize(0.28);
        $p1->SetCenter(0.25, 0.32);
        $p1->SetLegends(array_keys($data));
        $graph->Add($p1);
        $graph->Stroke(_IMG_HANDLER);

        return $graph;
    }

} 