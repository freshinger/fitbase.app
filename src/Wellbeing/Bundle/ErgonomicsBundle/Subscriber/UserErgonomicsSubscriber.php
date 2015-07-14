<?php

namespace Wellbeing\Bundle\ErgonomicsBundle\Subscriber;


use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomics;
use Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsBodyUpperForward;
use Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsBodyUpperLean;
use Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsBodyUpperRotation;
use Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsNeck;
use Wellbeing\Bundle\ErgonomicsBundle\Event\UserStateErgonomicsEvent;

class UserErgonomicsSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        return [
            'wellbeing.user_state_ergonomics_create' => ['onUserStateErgonomicsCreate']
        ];
    }

//        Process new user state ergonomics object
//
//
//        TiXmlElement* var11 = doc.FirstChildElement("Neck")->FirstChildElement("ll_Neck"); //lower limit healthy angle
//        TiXmlElement* var12 = doc.FirstChildElement("Neck")->FirstChildElement("lu_Neck"); //upper limit healthy angle
//        TiXmlElement* var13 = doc.FirstChildElement("Neck")->FirstChildElement("ref_Neck"); //reference healthy range (95% of all values should at least be covering this range)
//        TiXmlElement* var14 = doc.FirstChildElement("Neck")->FirstChildElement("el_Neck"); //error lower limit
//        TiXmlElement* var15 = doc.FirstChildElement("Neck")->FirstChildElement("eu_Neck"); //error upper limit
//
//        float mittel_nacken = mittelwert(smooth_winkel_nacken);
//        float std_nacken = standardabweichung(smooth_winkel_nacken);
//
//
//        // Nacken
//        if (mittel_nacken < (ll_Neck + el_Neck)) // wenn mittel kleiner als das untere Limit, dann Gewichtungsfaktor < 1
//        {
//            gew_nacken = mittel_nacken / (ll_Neck + el_Neck);
//        }
//        else if (mittel_nacken >(lu_Neck + eu_Neck)) // wenn mittel grˆﬂer als das obere Limit, dann Gewichtungsfaktor < 1
//        {
//            gew_nacken = (mittel_nacken - 180) / (lu_Neck + eu_Neck - 180);
//        }
//        else // Wenn mittel im Bereich zw unterem und oberen Limit, dann Gewichtungsfaktor = 1
//        {
//            gew_nacken = 1;
//        }
//
//        LBP_nacken = ((std_nacken * gew_nacken) / ref_Neck) - 1;
//
//
//        s << fixed << "Warning for neck joint!\n";
//        if (mittel_nacken < (ll_Neck + el_Neck))
//            s << "Your neck is extended too much. Straighten your neck.\n";
//        if (mittel_nacken >(lu_Neck + eu_Neck))
//            s << "Your neck is flexed too much. Straighten your neck.\n";
//        if (std_nacken < ref_Neck)
//            s << "Your posture is too static. Move your Head.\n";

//ref_UB_forward = ref_UB_forward / (1.96 * 2); // Referenz Varianz f¸r den im XML file beschriebenen Bereich. 95% aller Werte sollen in diesem Bereich mindestens vorkommen (siehe Master thesis s. 30)
//ref_UB_lean = ref_UB_lean / (1.96 * 2);
//ref_Neck = ref_Neck / (1.96 * 2);
//ref_LOS = ref_LOS / (1.96 * 2);
//ref_VD = ref_VD / (1.96 * 2);
//ref_Hip_right = ref_Hip_right / (1.96 * 2);
//ref_Hip_left = ref_Hip_left / (1.96 * 2);
//ref_Knee_right = ref_Knee_right / (1.96 * 2);
//ref_Knee_left = ref_Knee_left / (1.96 * 2);

    public function onUserStateErgonomicsCreate(UserStateErgonomicsEvent $event)
    {
        $datetime = $this->container->get('datetime');
        $entityManager = $this->container->get('entity_manager');
        $wellbeingErgonomics = $this->container->get('wellbeing.ergonomics');

        if (!($userState = $event->getEntity())) {
            throw new \LogicException('User state ergonomics object does not exists');
        }

        if (!($user = $event->getEntity()->getUser())) {
            throw new \LogicException('User can not be empty');
        }

        if (!($settingsNeck = $wellbeingErgonomics->getSettingsNeck())) {
            throw new \LogicException('Settings object for UserErgonomicsNeck not found');
        }

        if (!($settingsBodyUpperForward = $wellbeingErgonomics->getSettingsBodyUpperForward())) {
            throw new \LogicException('Settings object for UserErgonomicsBodyUpperForward not found');
        }

        if (!($settingsBodyUpperLean = $wellbeingErgonomics->getSettingsBodyUpperForward())) {
            throw new \LogicException('Settings object for UserErgonomicsBodyUpperLean not found');
        }

        if (!($settingsBodyUpperRotation = $wellbeingErgonomics->getSettingsBodyUpperRotation())) {
            throw new \LogicException('Settings object for UserErgonomicsBodyUpperLean not found');
        }

        $averageNeck = $wellbeingErgonomics->getAverageNeck($user);
        $deviationNeck = $wellbeingErgonomics->getDeviationNeck($user);
        $averageBodyUpperForward = $wellbeingErgonomics->getAverageBodyUpperForward($user);
        $deviationBodyUpperForward = $wellbeingErgonomics->getDeviationBodyUpperForward($user);
        $averageBodyUpperLean = $wellbeingErgonomics->getAverageBodyUpperForward($user);
        $deviationBodyUpperLean = $wellbeingErgonomics->getDeviationBodyUpperForward($user);
        $averageBodyUpperRotation = $wellbeingErgonomics->getAverageBodyUpperRotation($user);
        $deviationBodyUpperRotation = $wellbeingErgonomics->getDeviationBodyUpperRotation($user);

        $entity = (new UserErgonomics())
            ->setUser($user)
            ->setDate($datetime->getDateTime('now'))
            ->setNeck(
                (new UserErgonomicsNeck())
                    ->setAngle($userState->getAngleNeck())
                    ->setCorrect($wellbeingErgonomics->isAngleSafe(
                        $averageNeck, $deviationNeck, $settingsNeck
                    ))
            )->setBodyUpperForward(
                (new UserErgonomicsBodyUpperForward())
                    ->setAngle($userState->getAngleBodyUpperForward())
                    ->setCorrect($wellbeingErgonomics->isAngleSafe(
                        $averageBodyUpperForward, $deviationBodyUpperForward, $settingsBodyUpperForward
                    ))
            )->setBodyUpperLean(
                (new UserErgonomicsBodyUpperLean())
                    ->setAngle($userState->getAngleBodyUpperLean())
                    ->setCorrect($wellbeingErgonomics->isAngleSafe(
                        $averageBodyUpperLean, $deviationBodyUpperLean, $settingsBodyUpperLean
                    ))
            )->setBodyUpperRotation(
                (new UserErgonomicsBodyUpperRotation())
                    ->setAngle($userState->getAngleBodyUpperRotation())
                    ->setCorrect($wellbeingErgonomics->isAngleSafe(
                        $averageBodyUpperRotation, $deviationBodyUpperRotation, $settingsBodyUpperRotation
                    ))
            );

        $entityManager->persist($entity);
        $entityManager->flush($entity);
        $entityManager->refresh($entity);
    }
}