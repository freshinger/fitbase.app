<?php
namespace Fitbase\Bundle\WeeklytaskBundle\Form\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * @Annotation
 */
class WeeklyquizUserAnswerValidator extends ConstraintValidator implements ContainerAwareInterface
{

    protected $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     *
     * @param mixed $entity
     * @param Constraint $constraint
     * @return bool
     */
    public function validate($entity, Constraint $constraint)
    {

        $managerEntity = $this->container->get('entity_manager');
        $repositoryWeeklyquizAnswer = $managerEntity->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizAnswer');
        $repositoryWeeklyquizQuestion = $managerEntity->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizQuestion');




        $this->context->addViolation('Es gibt keine Antworten', array());
        return false;
    }
}