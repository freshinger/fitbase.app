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
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('health', array($this, 'getPercentHealth')),
            new \Twig_SimpleFilter('strain', array($this, 'getPercentStrain')),
        );
    }

    /**
     * @param $points
     * @return int
     */
    public function getPercentHealth($points)
    {
        return $this->container->get('questionnaire')->getHealthPercent($points);
    }

    /**
     * @param int $points
     * @return int
     */
    public function getPercentStrain($points = 0)
    {
        return $this->container->get('questionnaire')->getStrainPercent($points);
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