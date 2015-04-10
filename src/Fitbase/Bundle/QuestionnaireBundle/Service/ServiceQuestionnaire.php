<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 9/11/14
 * Time: 11:32 AM
 */

namespace Fitbase\Bundle\QuestionnaireBundle\Service;


use Symfony\Component\DependencyInjection\ContainerAware;

class ServiceQuestionnaire extends ContainerAware
{

    /**
     * Get company assessment
     * @return null
     */
    public function assessment()
    {
        if (($company = $this->container->get('company')->current())) {
            return $company->getQuestionnaire();
        }
        return null;
    }


    /**
     * Calculate health percent from points
     * @param $points
     * @return float
     */
    public function getHealthPercent($points)
    {
        return round((($healthNew = (75 + $points)) > 0) ? $healthNew : 0);
    }

    /**
     * Calculate strain percent from points
     * @param $points
     * @return float
     */
    public function getStrainPercent($points)
    {
        return round((($strainNew = (50 + $points)) > 0) ? $strainNew : 0);
    }

} 