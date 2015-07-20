<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 27/04/15
 * Time: 10:54
 */

namespace Wellbeing\Bundle\ErgonomicsBundle\Controller;


use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Wellbeing\Bundle\ErgonomicsBundle\Event\UserErgonomicsMessageEvent;

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
        $datetime = $this->get('datetime');
        $entityManager = $this->get('entity_manager');
        $wellbeingErgonomicsHelper = $this->get('wellbeing_helper.ergonomics');

        $repositoryErgonomics = $entityManager->getRepository('Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomics');
        $repositoryErgonomicsMessage = $entityManager->getRepository('Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsMessage');

        if (!($user = $this->get('user')->current())) {
            throw new \LogicException('User object can not be empty');
        }

        $date1 = $datetime->getDateTime('now');
        $date2 = $datetime->getDateTime('now');
        $date1->modify('-5 min');

        if (($message = $repositoryErgonomicsMessage->findLastNotProcessedByUser($user, $date1))) {

            $event = new UserErgonomicsMessageEvent($message);
            $this->get('event_dispatcher')->dispatch('wellbeing.user_ergonomics_message_done', $event);

            return new JsonResponse([
                "icon" => null,
                "date" => $date2->getTimestamp(),
                "correct" => $message->getCorrect(),
                "title" => $wellbeingErgonomicsHelper->getErgonomicsMessageTitle($message),
                "text" => $wellbeingErgonomicsHelper->getErgonomicsMessageText($message),
            ], 200);
        }

        $date1 = $datetime->getDateTime('now');
        $date2 = $datetime->getDateTime('now');
        $date1->modify('-10 sec');

        $collection = $repositoryErgonomics->getByInterval($user, $date1, $date2);
        if ($collection instanceof ArrayCollection and !$collection->count()) {
            return new JsonResponse([
                "icon" => null,
                "date" => $date2->getTimestamp(),
                "correct" => null,
                "title" => $wellbeingErgonomicsHelper->getErgonomicsMessageTitle(null),
                "text" => $wellbeingErgonomicsHelper->getErgonomicsMessageText(null),
            ], 200);
        }

        return new JsonResponse([], 200);
    }
}