<?php
namespace Wellbeing\Bundle\ErgonomicsBundle\Tests\Entity;

use Fitbase\Bundle\FitbaseBundle\Tests\FitbaseTestAbstract;
use Wellbeing\Bundle\ErgonomicsBundle\Entity\UserStateErgonomics;

class UserStateErgonomicsTest extends FitbaseTestAbstract
{
    /**
     * @return UserStateErgonomics
     */
    protected function getUserStateErgonomics()
    {
        return (new UserStateErgonomics());
    }

    public function testGetAngleXYShouldReturnCorrectAngle90()
    {
        $entity = $this->getUserStateErgonomics();

        $this->assertEquals($entity->getAngleXY(0, 2, 2, 0), 90);
    }

    public function testGetAngleXYShouldReturnCorrectAngle180()
    {
        $entity = $this->getUserStateErgonomics();

        $this->assertEquals($entity->getAngleXY(0, 2, 0, -1), 180);
    }

    public function testGetAngleXYZShouldReturnCorrectAngle90()
    {
        $entity = $this->getUserStateErgonomics();

        $this->assertEquals($entity->getAngleXYZ(0, 2, 0, 2, 0, 0), 90);
    }

    public function testGetAngleXYZShouldReturnCorrectAngle180()
    {
        $entity = $this->getUserStateErgonomics();

        $this->assertEquals($entity->getAngleXYZ(0, 2, 0, 0, -2, 0), 180);
    }
}