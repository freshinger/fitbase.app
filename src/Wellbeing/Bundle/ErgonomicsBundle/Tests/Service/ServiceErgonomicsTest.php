<?php

namespace Wellbeing\Bundle\ErgonomicsBundle\Tests\Service;


use Doctrine\Common\Collections\ArrayCollection;
use Fitbase\Bundle\FitbaseBundle\Tests\FitbaseTestAbstract;
use Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomics;
use Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsBodyUpperForward;
use Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsBodyUpperLean;
use Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsBodyUpperRotation;
use Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsNeck;
use Wellbeing\Bundle\ErgonomicsBundle\Service\ServiceErgonomics;

class ServiceErgonomicsTest extends FitbaseTestAbstract
{
    /**
     * Setup user ergonomics object
     * for current text
     *
     * @return UserErgonomics
     */
    protected function getUserErgonomics()
    {
        return (new UserErgonomics())
            ->setNeck(
                (new UserErgonomicsNeck())
                    ->setCorrect(true)
            )->setBodyUpperForward(
                (new UserErgonomicsBodyUpperForward())
                    ->setCorrect(true)
            )->setBodyUpperLean(
                (new UserErgonomicsBodyUpperLean())
                    ->setCorrect(true)
            )->setBodyUpperRotation(
                (new UserErgonomicsBodyUpperRotation())
                    ->setCorrect(true)
            );
    }

    public function testCheckShouldReturnTrueForMoreAs40PercentTrue()
    {
        $entityManager = $this->getEntityManager();
        $eventDispatcher = $this->getEventDispatcher();
        $datetime = $this->container()->get('datetime');

        $service = new ServiceErgonomics($entityManager, $eventDispatcher, $datetime);

        $ergonomics1 = $this->getUserErgonomics();
        $ergonomics1->getNeck()->setCorrect(false);

        $this->assertTrue($service->check(new ArrayCollection([
            $this->getUserErgonomics(),
            $this->getUserErgonomics(),
            $this->getUserErgonomics(),
            $this->getUserErgonomics(),
            $this->getUserErgonomics(),
            $ergonomics1,
            $ergonomics1,
            $ergonomics1,
            $ergonomics1,
            $ergonomics1,
        ])));
    }

    public function testCheckShouldReturnFalseForMoreAs65PercentFalse()
    {
        $entityManager = $this->getEntityManager();
        $eventDispatcher = $this->getEventDispatcher();
        $datetime = $this->container()->get('datetime');

        $service = new ServiceErgonomics($entityManager, $eventDispatcher, $datetime);

        $ergonomics1 = $this->getUserErgonomics();
        $ergonomics1->getNeck()->setCorrect(false);

        $this->assertFalse($service->check(new ArrayCollection([
            $this->getUserErgonomics(),
            $this->getUserErgonomics(),
            $this->getUserErgonomics(),
            $ergonomics1,
            $ergonomics1,
            $ergonomics1,
            $ergonomics1,
            $ergonomics1,
            $ergonomics1,
            $ergonomics1,
        ])));
    }

} 