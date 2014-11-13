<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 8/25/14
 * Time: 2:44 PM
 */

namespace Fitbase\Bundle\FitbaseBundle\Service;


use Symfony\Component\DependencyInjection\ContainerAware;

class ServiceFitbase extends ContainerAware
{
    /**
     * Get current post record
     * @return mixed
     */
    public function getCurrentPost()
    {
        global $module_parent_page_id;

        if (!empty($module_parent_page_id)) {
            $managerEntityFitbase = $this->container->get('doctrine.orm.entity_manager');
            $repositoryPost = $managerEntityFitbase->getRepository('Fitbase\Bundle\FitbaseBundle\Entity\Post');
            return $repositoryPost->find($module_parent_page_id);
        }

        return null;
    }

    /**
     * Get current user for fitbase
     * @return null
     */
    public function current()
    {
        $apiWordpress = $this->container->get('fitbase_wordpress.api');
        if (($userCurrent = $apiWordpress->wpGetCurrentUser())) {
            $managerEntityFitbase = $this->container->get('doctrine.orm.entity_manager');
            $repositoryUser = $managerEntityFitbase->getRepository('Fitbase\Bundle\FitbaseBundle\Entity\User');
            return $repositoryUser->find($userCurrent->ID);
        }
        return null;
    }
}