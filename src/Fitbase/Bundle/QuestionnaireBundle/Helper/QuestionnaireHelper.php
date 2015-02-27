<?php
namespace Fitbase\Bundle\QuestionnaireBundle\Helper;

use Fitbase\Bundle\AufgabeBundle\Entity\WeeklytaskUser;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class QuestionnaireHelper extends \Twig_Extension implements ContainerAwareInterface
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
    public function getFunctions()
    {
        return array(
//            new \Twig_SimpleFunction('companyQuestionnairePie', array($this, 'getCompanyQuestionnairePie')),
        );
    }

//    /**
//     * Get
//     * @param null $name
//     * @param null $data
//     * @return null|string
//     */
//    public function getCompanyQuestionnairePie($name = null, $data = null)
//    {
//        $serviceGraph = $this->container->get('graph');
//        if (($graph = $serviceGraph->pie($name, $data))) {
//            ob_start();
//            $graph->img->Stream();
//            $image = ob_get_contents();
//            ob_end_clean();
//            return '<img style="width: 100%;" src="data:image/png;base64,' . base64_encode($image) . '"  />';
//        }
//
//        return null;
//    }


    /**
     * @return array
     */
    public function getFilters()
    {
        return array();
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'fitbase_questionnaire_extension';
    }
}