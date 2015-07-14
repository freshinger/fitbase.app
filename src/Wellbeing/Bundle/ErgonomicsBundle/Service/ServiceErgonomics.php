<?php
namespace Wellbeing\Bundle\ErgonomicsBundle\Service;

use Application\Sonata\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAware;
use Wellbeing\Bundle\ApiBundle\Model\UserState;
use Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsSettings;
use Wellbeing\Bundle\ErgonomicsBundle\Event\UserStateErgonomicsEvent;
use Wellbeing\Bundle\ErgonomicsBundle\Form\DataTransformer\UserStateDataTransformer;

class ServiceErgonomics extends ContainerAware
{
    /**
     * Store user state for Ergonomics
     *
     * @param User $user
     * @param UserState $model
     * @return bool
     */
    public function state(User $user, UserState $model)
    {
        $entity = (new UserStateDataTransformer())
            ->reverseTransform($model)
            ->setUser($user);

        $this->container->get('entity_manager')->persist($entity);
        $this->container->get('entity_manager')->flush($entity);
        $this->container->get('entity_manager')->refresh($entity);

        $event = new UserStateErgonomicsEvent($entity);
        $this->container->get('event_dispatcher')
            ->dispatch('wellbeing.user_state_ergonomics_create', $event);

        return true;
    }

    /**
     * Get average value
     *
     * @param User $user
     * @param null $code
     * @return null
     */
    public function average(User $user, $code = null)
    {
        $entityManager = $this->container->get('entity_manager');
        $repository = $entityManager->getRepository('Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsNeck');
        return $repository->findAverage($user);
    }

//template <typename T> // Varianz-Template
//T varianz(std::vector<T> &vec) {
//float mit2_vec = mittelwert(vec) * mittelwert(vec);
//for (int i = 0; i < vec.size(); ++i)
//vec[i] *= vec[i];
//float mit2_vec2 = mittelwert(vec);
//return (mit2_vec2 - mit2_vec);
//}
//
//template <typename T> // Varianz-Template
//T standardabweichung(std::vector<T> &vec) {
//    float var = varianz(vec);
//	return pow(var,0.5); //standardaweichung ist die Wurzel der Varianz
//}

    public function deviation(User $user, $code = null)
    {
        $average = $this->average($user, $code);
        $mit2_vec = $average * $average;

        $entityManager = $this->container->get('entity_manager');
        $repository = $entityManager->getRepository('Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsNeck');
        if (($collection = $repository->findByUser($user))) {
            $summ = 0;
            foreach ($collection as $id => $element) {
                $summ += $element->getAngle() * $element->getAngle();
            }
            $mit2_vec2 = $summ / count($collection);

            return sqrt(($mit2_vec2 - $mit2_vec));
        }
        return null;
    }


    /**
     * Get settings for
     *
     * @param null $code
     * @return UserErgonomicsSettings
     */
    public function settings($code = null)
    {
        //<Neck>
        //<ll_Neck>80</ll_Neck>
        //<lu_Neck>100</lu_Neck>
        //<ref_Neck>8</ref_Neck>
        //<el_Neck>-11.06</el_Neck>
        //<eu_Neck>30.22</eu_Neck>
        //</Neck>
        return (new UserErgonomicsSettings())
            ->setCode('neck')
            ->setRange(8)
            ->setLower(80)
            ->setLowerError(-11.06)
            ->setUpper(100)
            ->setUpperError(30.22);
//
//        //<UB_lean>
//        //<ll_UB_lean>85</ll_UB_lean>
//        //<lu_UB_lean>95</lu_UB_lean>
//        //<ref_UB_lean>4</ref_UB_lean>
//        //<el_UB_lean>-8.10</el_UB_lean>
//        //<eu_UB_lean>3.48</eu_UB_lean>
//        //</UB_lean>
//        if ($code == 'body_upper_lean') {
//            return (new UserErgonomicsSettings())
//                ->setCode('body_upper_lean')
//                ->setRange(4)
//                ->setLower(85)
//                ->setLowerError(-8.10)
//                ->setUpper(95)
//                ->setUpperError(3.48);
//        }
//
//        //<UB_forward>
//        //    <ll_UB_forward>90</ll_UB_forward>
//        //    <lu_UB_forward>120</lu_UB_forward>
//        //    <ref_UB_forward>8</ref_UB_forward>
//        //    <el_UB_forward>-11.78</el_UB_forward>
//        //    <eu_UB_forward>3.67</eu_UB_forward>
//        //</UB_forward>
//        if ($code == 'body_upper_forward') {
//            return (new UserErgonomicsSettings())
//                ->setCode('body_upper_front')
//                ->setRange(8)
//                ->setLower(90)
//                ->setLowerError(-11.78)
//                ->setUpper(120)
//                ->setUpperError(3.67);
//        }
//
//        return null;
    }

    /**
     * Calculate Low Back Pain Index
     *
     * @param $average
     * @param $deviation
     * @param $settings
     * @return float
     */
    public function lbp($average, $deviation, $settings)
    {
        // wenn mittel kleiner als das untere Limit, dann Gewichtungsfaktor < 1
        if ($average < ($settings->getLower() + $settings->getLowerError())) {
            $result = $average / ($settings->getLower() + $settings->getLowerError());
            // wenn mittel grˆﬂer als das obere Limit, dann Gewichtungsfaktor < 1
        } else if ($average > ($settings->getUpper() + $settings->getUpperError())) {
            $result = ($average - 180) / ($settings->getUpper() + $settings->getUpperError() - 180);
            // Wenn mittel im Bereich zw unterem und oberen Limit, dann Gewichtungsfaktor = 1
        } else {
            $result = 1;
        }

        return (($deviation * $result) / $settings->getRange()) - 1;
    }
}