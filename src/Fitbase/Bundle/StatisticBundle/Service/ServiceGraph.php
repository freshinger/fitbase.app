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

        $graph = new PieGraph(350, 380);
        $graph->SetShadow();
        $graph->title->Set($name);

        $theme_class = new \UniversalTheme;
        $graph->SetTheme($theme_class);

        if (array_sum(array_values($data)) > 0) {
            $p1 = new PiePlot(array_values($data));
            $p1->SetSize(0.28);
            $p1->SetCenter(0.25, 0.32);
            $p1->SetLegends(array_keys($data));
            $p1->ExplodeAll(10);
            $graph->Add($p1);
        }


        $graph->Stroke(_IMG_HANDLER);

        return $graph;
    }

    public function bar($name = null, $data = array(10, 10, 10, 10, 10, 10, 10, 10, 10, 10,))
    {
        JpGraph::load();
        JpGraph::module('line');
        JpGraph::module('bar');


        $graph = new \Graph(335, 400, 'auto');
        $graph->SetScale("textlin");

        $graph->SetTheme(new \UniversalTheme);
        $graph->SetMargin(50, 40, 40, 40);
        $graph->img->SetAngle(0);

        $graph->SetBox(false);

        $graph->ygrid->Show(false);
        $graph->ygrid->SetFill(false);
        $graph->xaxis->SetTickLabels(array_keys($data));

        $graph->yaxis->HideLine(false);
        $graph->yaxis->HideTicks(false, false);

        $graph->SetBackgroundGradient('#FFFFFF', '#FFFFFF', GRAD_HOR, BGRAD_PLOT);

        $b1plot = new \BarPlot(array_values($data));
        $b1plot->SetFillGradient("#c0e3e8", "#FFFFFF", GRAD_HOR);
        $b1plot->SetWidth(60);
        $b1plot->SetWeight(0);
        $graph->Add($b1plot);

        return $graph;
    }
}