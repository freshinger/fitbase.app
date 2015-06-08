<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 27/04/15
 * Time: 10:54
 */

namespace Wellbeing\Bundle\ApiBundle\Controller;


use Sonata\AdminBundle\Controller\CoreController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserStateController extends CoreController
{
    /**
     * Display last actual state of user
     * @param Request $request
     * @return Response
     */
    public function historyAction(Request $request)
    {
        $entityManager = $this->get('entity_manager');
        $repositoryUserState = $entityManager->getRepository('Wellbeing\Bundle\ApiBundle\Entity\UserState');

        if (!($user = $this->get('user')->current())) {
            throw new \LogicException('User object can not be empty');
        }

        return $this->render('Wellbeing/UserState/History.html.twig', array(
            'collection' => $repositoryUserState->findByUser($user)
        ));
    }
}