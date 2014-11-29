<?php
namespace Fitbase\Bundle\GamificationBundle\Form\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * @Annotation
 */
class GamificationUserDialogAnswerValidator extends ConstraintValidator implements ContainerAwareInterface
{

    protected $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param mixed $entity
     * @param Constraint $constraint
     * @return bool
     */
    public function validate($entity, Constraint $constraint)
    {
        if ($entity->getQuestion()) {

            switch ($entity->getQuestion()->getType()) {
                case 'text':
                    if (!strlen($entity->getDescription())) {
                        $this->context->addViolation($constraint->message, array());
                        return false;
                    }
            }
        }
        return true;
    }
}