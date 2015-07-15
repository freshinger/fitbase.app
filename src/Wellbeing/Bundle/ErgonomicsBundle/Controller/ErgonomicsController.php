<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 27/04/15
 * Time: 10:54
 */

namespace Wellbeing\Bundle\ErgonomicsBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ErgonomicsController extends Controller
{
    /**
     * Get information about current user state
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function messageAction(Request $request)
    {
        $wellbeingErgonomics = $this->container->get('wellbeing.ergonomics');
        if (!($user = $this->get('user')->current())) {
            throw new \LogicException('User object can not be empty');
        }


        return new JsonResponse([
            "correct" => $wellbeingErgonomics->check($user),
            "label" => "Alles gut, weiter machen",
            "date" => $this->get('datetime')->getDateTime('now')->getTimestamp(),
            "message" => "Ändern sie bitte ihre Position",
        ], 200);
    }

}