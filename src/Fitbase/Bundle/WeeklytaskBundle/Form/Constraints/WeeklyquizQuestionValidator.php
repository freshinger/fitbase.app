<?php
namespace Fitbase\Bundle\WeeklytaskBundle\Form\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * @Annotation
 */
class WeeklyquizQuestionValidator extends ConstraintValidator implements ContainerAwareInterface
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
        if (!count($entity)) {
            $this->context->addViolation('Es gibt keine Antworten', array());
            return false;
        }

        $managerEntity = $this->container->get('entity_manager');

        $repositoryWeeklyquizAnswer = $managerEntity->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizAnswer');
        foreach ($entity as $questionId => $answerId) {
            if (($answer = $repositoryWeeklyquizAnswer->find($answerId))) {
                if (!$answer->getCorrect()) {
                    $this->context->addViolation('Die Antwort ist falsch', array(), $answerId);
                    continue;
                }
            }
        }

        return !(count($this->context->getViolations()) > 0);
    }
}