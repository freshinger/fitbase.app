<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 17/03/15
 * Time: 15:19
 */
namespace Fitbase\Bundle\FitbaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


abstract class SecuredControllerAbstract extends Controller
{
    /**
     * Check user rights for current secured controller
     * @param $name
     * @param array $parameters
     * @return mixed
     */
    public function __call($name, array $parameters = array())
    {
        if (($roles = $this->getRoles())) {
            if (($securityContext = $this->get('security.context'))) {
                foreach ($roles as $role) {
                    if ($securityContext->isGranted($role)) {
                        return call_user_func_array(array($this, $name), $parameters);
                    }
                }
            }
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return call_user_func_array(array($this, $name), $parameters);
    }

    /**
     * Define a controller -specified roles
     * @return mixed
     */
    abstract protected function getRoles();
} 