<?php

namespace Wellbeing\Bundle\ErgonomicsBundle\Subscriber;


use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsNeck;
use Wellbeing\Bundle\ErgonomicsBundle\Event\UserStateErgonomicsEvent;

class UserErgonomicsNeckSubscriber extends ContainerAware implements EventSubscriberInterface
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
    public function onUserStateErgonomicsCreate(UserStateErgonomicsEvent $event)
    {
        if (!($userState = $event->getEntity())) {
            throw new \LogicException('User state ergonomics object does not exists');
        }

        if (!($user = $event->getEntity()->getUser())) {
            throw new \LogicException('User can not be empty');
        }

        if (!($settings = $this->container->get('wellbeing.ergonomics')->settings('neck'))) {
            throw new \LogicException('User state ergonomics object does not exists');
        }

        $entity = (new UserErgonomicsNeck())
            ->setUser($user)
            ->setAngle($userState->getAngleNeck())
            ->setDate($this->container->get('datetime')->getDateTime('now'))
            ->setCorrect(null);

        if (($average = $this->container->get('wellbeing.ergonomics')->average($user, 'neck'))) {
            if (($deviation = $this->container->get('wellbeing.ergonomics')->deviation($user, 'neck'))) {
                if (($lbp = $this->container->get('wellbeing.ergonomics')->lbp($average, $deviation, $settings)) < 0) {

                    if (($average < ($settings->getLower() + $settings->getLowerError()))) {
                        $entity->setCorrect(false);
                    }

                    if (($average > ($settings->getUpper() + $settings->getUpperError()))) {
                        $entity->setCorrect(false);
                    }

                    if (($deviation < $settings->getRange())) {
                        $entity->setCorrect(false);
                    }
                }
            }
        }

        $this->container->get('entity_manager')->persist($entity);
        $this->container->get('entity_manager')->flush($entity);
        $this->container->get('entity_manager')->refresh($entity);
    }

} 