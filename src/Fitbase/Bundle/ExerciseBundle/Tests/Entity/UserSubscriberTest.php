<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 03/02/15
 * Time: 14:54
 */

namespace Fitbase\Bundle\ExerciseBundle\Tests\Entity;


use Application\Sonata\ClassificationBundle\Entity\Category;
use Application\Sonata\UserBundle\Entity\User;
use Doctrine\ORM\Mapping\ClassMetadata;
use Fitbase\Bundle\ExerciseBundle\Component\Chooser\ChooserExerciseRandom;
use Fitbase\Bundle\ExerciseBundle\Entity\Exercise;
use Fitbase\Bundle\ExerciseBundle\Entity\ExerciseManager;
use Fitbase\Bundle\ExerciseBundle\Subscriber\UserSubscriber;
use Fitbase\Bundle\FitbaseBundle\Tests\FitbaseTestAbstract;
use Fitbase\Bundle\UserBundle\Event\UserEvent;

class UserSubscriberTest extends FitbaseTestAbstract
{
    /**
     * Setup user object for this
     * test only
     * @return User
     */
    protected function getUser()
    {
        return (new User());
    }


    public function testFindTypeByFocusCategoryTypeAndStepShouldProcessNullValueForSteps()
    {
        $entityManager = $this->getEntityManager();

        $entityManager->expects($this->any())
            ->method('getClassMetadata')
            ->will($this->returnValue(
                new ClassMetadata('Exercise')
            ));

        $manager = new ExerciseManager($entityManager);
        $types = $manager->findTypeByFocusCategoryTypeAndStep(null, 0);

        $this->assertEquals(count($types), 3);
        $this->assertEquals($types[0], Exercise::MOBILISATION);
        $this->assertEquals($types[1], Exercise::KRAEFTIGUNG);
        $this->assertEquals($types[2], null);

        $types = $manager->findTypeByFocusCategoryTypeAndStep(null, 1);

        $this->assertEquals(count($types), 3);
        $this->assertEquals($types[0], Exercise::KRAEFTIGUNG);
        $this->assertEquals($types[1], Exercise::DAEHNUNG);
        $this->assertEquals($types[2], null);

        $types = $manager->findTypeByFocusCategoryTypeAndStep(null, 2);

        $this->assertEquals(count($types), 4);
        $this->assertEquals($types[0], Exercise::DAEHNUNG);
        $this->assertEquals($types[1], Exercise::KRAEFTIGUNG);
        $this->assertEquals($types[2], Exercise::MOBILISATION);
        $this->assertEquals($types[3], null);
    }


    public function testFindTypeByFocusCategoryTypeAndStepShouldProcess0ValueForSteps()
    {
        $entityManager = $this->getEntityManager();

        $entityManager->expects($this->any())
            ->method('getClassMetadata')
            ->will($this->returnValue(
                new ClassMetadata('Exercise')
            ));

        $manager = new ExerciseManager($entityManager);
        $types = $manager->findTypeByFocusCategoryTypeAndStep(0, 0);

        $this->assertEquals(count($types), 3);
        $this->assertEquals($types[0], Exercise::MOBILISATION);
        $this->assertEquals($types[1], Exercise::KRAEFTIGUNG);
        $this->assertEquals($types[2], null);

        $types = $manager->findTypeByFocusCategoryTypeAndStep(0, 1);

        $this->assertEquals(count($types), 3);
        $this->assertEquals($types[0], Exercise::KRAEFTIGUNG);
        $this->assertEquals($types[1], Exercise::MOBILISATION);
        $this->assertEquals($types[2], null);

        $types = $manager->findTypeByFocusCategoryTypeAndStep(0, 2);

        $this->assertEquals(count($types), 4);
        $this->assertEquals($types[0], Exercise::DAEHNUNG);
        $this->assertEquals($types[1], Exercise::KRAEFTIGUNG);
        $this->assertEquals($types[2], Exercise::MOBILISATION);
        $this->assertEquals($types[3], null);
    }


    public function testFindTypeByFocusCategoryTypeAndStepShouldProcess1ValueForSteps()
    {
        $entityManager = $this->getEntityManager();

        $entityManager->expects($this->any())
            ->method('getClassMetadata')
            ->will($this->returnValue(
                new ClassMetadata('Exercise')
            ));

        $manager = new ExerciseManager($entityManager);
        $types = $manager->findTypeByFocusCategoryTypeAndStep(1, 0);

        $this->assertEquals(count($types), 2);
        $this->assertEquals($types[0], Exercise::MOBILISATION);
        $this->assertEquals($types[1], null);

        $types = $manager->findTypeByFocusCategoryTypeAndStep(1, 1);

        $this->assertEquals(count($types), 2);
        $this->assertEquals($types[0], Exercise::MOBILISATION);
        $this->assertEquals($types[1], null);

        $types = $manager->findTypeByFocusCategoryTypeAndStep(1, 2);

        $this->assertEquals(count($types), 3);
        $this->assertEquals($types[0], Exercise::DAEHNUNG);
        $this->assertEquals($types[1], Exercise::KRAEFTIGUNG);
        $this->assertEquals($types[2], null);
    }


    public function testFindTypeByFocusCategoryTypeAndStepShouldProcess2ValueForSteps()
    {
        $entityManager = $this->getEntityManager();

        $entityManager->expects($this->any())
            ->method('getClassMetadata')
            ->will($this->returnValue(
                new ClassMetadata('Exercise')
            ));

        $manager = new ExerciseManager($entityManager);
        $types = $manager->findTypeByFocusCategoryTypeAndStep(2, 0);

        $this->assertEquals(count($types), 2);
        $this->assertEquals($types[0], Exercise::KRAEFTIGUNG);
        $this->assertEquals($types[1], null);

        $types = $manager->findTypeByFocusCategoryTypeAndStep(2, 1);

        $this->assertEquals(count($types), 2);
        $this->assertEquals($types[0], Exercise::KRAEFTIGUNG);
        $this->assertEquals($types[1], null);

        $types = $manager->findTypeByFocusCategoryTypeAndStep(2, 2);

        $this->assertEquals(count($types), 3);
        $this->assertEquals($types[0], Exercise::DAEHNUNG);
        $this->assertEquals($types[1], Exercise::MOBILISATION);
        $this->assertEquals($types[2], null);
    }
}