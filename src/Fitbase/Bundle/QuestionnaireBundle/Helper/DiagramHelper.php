<?php
namespace Fitbase\Bundle\QuestionnaireBundle\Helper;


class DiagramHelper extends \Fitbase\Bundle\FitbaseBundle\Helper\DiagramHelper
{

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('pie_questionnaire', array($this, 'getPieQuestionnaire')),
        );
    }

    /**
     *
     * @param $name
     * @param $data
     * @return null|string
     */
    public function getPieQuestionnaire($data, $name = null)
    {
        return $this->pie($name, $data);
    }


    public function getName()
    {
        return 'fitbase_diagram_questionnaire_extension';
    }
}