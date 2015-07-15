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
        $entityManager = $this->container->get('entity_manager');
        $eventDispatcher = $this->container->get('event_dispatcher');

        $entity = (new UserStateDataTransformer())
            ->reverseTransform($model)
            ->setUser($user);

        $entityManager->persist($entity);
        $entityManager->flush($entity);
        $entityManager->refresh($entity);

        $event = new UserStateErgonomicsEvent($entity);
        $eventDispatcher->dispatch('wellbeing.user_state_ergonomics_create', $event);

        return true;
    }

    /**
     * Get average value
     *
     * @param User $user
     * @return null
     */
    public function getAverageNeck(User $user)
    {
        $entityManager = $this->container->get('entity_manager');
        $repository = $entityManager->getRepository('Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsNeck');
        return $repository->findAverage($user);
    }

    /**
     * Get average value
     *
     * @param User $user
     * @return null
     */
    public function getAverageBodyUpperForward(User $user)
    {
        $entityManager = $this->container->get('entity_manager');
        $repository = $entityManager->getRepository('Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsBodyUpperForward');
        return $repository->findAverage($user);
    }

    /**
     * Get average value
     *
     * @param User $user
     * @return null
     */
    public function getAverageBodyUpperLean(User $user)
    {
        $entityManager = $this->container->get('entity_manager');
        $repository = $entityManager->getRepository('Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsBodyUpperLean');
        return $repository->findAverage($user);
    }

    /**
     * Get average value
     *
     * @param User $user
     * @return null
     */
    public function getAverageBodyUpperRotation(User $user)
    {
        $entityManager = $this->container->get('entity_manager');
        $repository = $entityManager->getRepository('Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsBodyUpperRotation');
        return $repository->findAverage($user);
    }

    /**
     * Calculate standard deviation for neck angle
     * @param User $user
     * @return float|null
     */
    public function getDeviationNeck(User $user)
    {
        if (($average = $this->getAverageNeck($user))) {
            $datetime = $this->container->get('datetime');
            $entityManager = $this->container->get('entity_manager');
            $repository = $entityManager->getRepository('Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsNeck');
            if (($collection = $repository->findByUser($user, $datetime))) {
                return $this->getDeviation($average, $collection);
            }
        }
        return null;
    }

    /**
     * Calculate standard deviation for neck angle
     * @param User $user
     * @return float|null
     */
    public function getDeviationBodyUpperForward(User $user)
    {
        if (($average = $this->getAverageBodyUpperForward($user))) {
            $datetime = $this->container->get('datetime');
            $entityManager = $this->container->get('entity_manager');
            $repository = $entityManager->getRepository('Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsBodyUpperForward');
            if (($collection = $repository->findByUser($user, $datetime))) {
                return $this->getDeviation($average, $collection);
            }
        }
        return null;
    }

    /**
     * Calculate standard deviation for neck angle
     * @param User $user
     * @return float|null
     */
    public function getDeviationBodyUpperLean(User $user)
    {
        if (($average = $this->getAverageBodyUpperLean($user))) {
            $datetime = $this->container->get('datetime');
            $entityManager = $this->container->get('entity_manager');
            $repository = $entityManager->getRepository('Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsBodyUpperLean');
            if (($collection = $repository->findByUser($user, $datetime))) {
                return $this->getDeviation($average, $collection);
            }
        }
        return null;
    }

    /**
     * Calculate standard deviation for neck angle
     * @param User $user
     * @return float|null
     */
    public function getDeviationBodyUpperRotation(User $user)
    {
        if (($average = $this->getAverageBodyUpperRotation($user))) {
            $datetime = $this->container->get('datetime');
            $entityManager = $this->container->get('entity_manager');
            $repository = $entityManager->getRepository('Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsBodyUpperRotation');
            if (($collection = $repository->findByUser($user, $datetime))) {
                return $this->getDeviation($average, $collection);
            }
        }
        return null;
    }

    //<Neck>
    //<ll_Neck>80</ll_Neck>
    //<lu_Neck>100</lu_Neck>
    //<ref_Neck>8</ref_Neck>
    //<el_Neck>-11.06</el_Neck>
    //<eu_Neck>30.22</eu_Neck>
    //</Neck>
    /**
     * Get settings for neck
     *
     * @return UserErgonomicsSettings
     */
    public function getSettingsNeck()
    {
        $entityManager = $this->container->get('entity_manager');
        $repository = $entityManager->getRepository('Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsSettings');
        return $repository->findOneByCode('neck');
    }

    //<UB_forward>
    //    <ll_UB_forward>90</ll_UB_forward>
    //    <lu_UB_forward>120</lu_UB_forward>
    //    <ref_UB_forward>8</ref_UB_forward>
    //    <el_UB_forward>-11.78</el_UB_forward>
    //    <eu_UB_forward>3.67</eu_UB_forward>
    //</UB_forward>
    /**
     * Get settings for upper body forward angle
     * @return mixed
     */
    public function getSettingsBodyUpperForward()
    {
        $entityManager = $this->container->get('entity_manager');
        $repository = $entityManager->getRepository('Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsSettings');
        return $repository->findOneByCode('body_upper_forward');
    }

    //<UB_lean>
    //<ll_UB_lean>85</ll_UB_lean>
    //<lu_UB_lean>95</lu_UB_lean>
    //<ref_UB_lean>4</ref_UB_lean>
    //<el_UB_lean>-8.10</el_UB_lean>
    //<eu_UB_lean>3.48</eu_UB_lean>
    //</UB_lean>
    /**
     * Get settings for upper body lean angle
     * @return mixed
     */
    public function getSettingsBodyUpperLean()
    {
        $entityManager = $this->container->get('entity_manager');
        $repository = $entityManager->getRepository('Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsSettings');
        return $repository->findOneByCode('body_upper_lean');
    }

    //<LOS>
    //<ll_LOS>0</ll_LOS>
    //<lu_LOS>60</lu_LOS>
    //<ref_LOS>5</ref_LOS>
    //<el_LOS>0</el_LOS>
    //<eu_LOS>0</eu_LOS>
    //</LOS>
    /**
     * Get settings for upper body lean angle
     * @return mixed
     */
    public function getSettingsBodyUpperRotation()
    {
        $entityManager = $this->container->get('entity_manager');
        $repository = $entityManager->getRepository('Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsSettings');
        return $repository->findOneByCode('body_upper_rotation');
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
    /**
     * Calculate std deviation
     * @param $average
     * @param $collection
     * @return float|null
     */
    protected function getDeviation($average, $collection)
    {
        $mit2_vec = $average * $average;
        if (count($collection)) {
            $summ = 0;
            foreach ($collection as $id => $element) {
                $summ += ($element->getAngle() * $element->getAngle());
            }
            $mit2_vec2 = $summ / count($collection);

            return sqrt(($mit2_vec2 - $mit2_vec));
        }
        return null;
    }

    /**
     * Code from Rainer
     * @param $average
     * @param $deviation
     * @param $settings
     * @return bool
     */
    public function isAngleSafe($average, $deviation, $settings)
    {
        if (($average < ($settings->getLower() + $settings->getLowerError()))) {
            return false;
        }

        if (($average > ($settings->getUpper() + $settings->getUpperError()))) {
            return false;
        }

        if (($deviation < $settings->getRangeOriginal())) {
            return false;
        }

        return true;
    }


    /**
     *
     * @param $user
     * @return bool
     */
    public function check($user, $interval = 1)
    {
        $entityManager = $this->container->get('entity_manager');
        $repository = $entityManager->getRepository('Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomics');

        $datetime = $this->container->get('datetime');
        $date = $datetime->getDateTime('now');
        $date->modify("-{$interval} min");

        if (!($collection = $repository->findLastByUserAndDate($user, $date))) {
            return true;
        }

        $countNeck = 0;
        $countBodyUpperForward = 0;
        $countBodyUpperLean = 0;
        $countBodyUpperRotation = 0;

        foreach ($collection as $element) {

            if ($element->getNeck()->getCorrect() === false) {
                $countNeck++;
            }

            if ($element->getBodyUpperForward()->getCorrect() === false) {
                $countBodyUpperForward++;
            }

            if ($element->getBodyUpperLean()->getCorrect() === false) {
                $countBodyUpperLean++;
            }

            if ($element->getBodyUpperRotation()->getCorrect() === false) {
                $countBodyUpperRotation++;
            }

            $element->setProcessed(true);
            $element->setProcessedDate($datetime->getDateTime('now'));
            $entityManager->persist($element);
        }
        $entityManager->flush();

        $countTotal = count($collection);
        return !($countNeck == $countTotal
            or $countBodyUpperForward == $countTotal
            or $countBodyUpperLean == $countTotal
            or $countBodyUpperRotation == $countTotal);

        return true;
    }

}