<?php
namespace Fitbase\Bundle\ReminderBundle\Form\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * @Annotation
 */
class ReminderUserItemCountValidator extends ConstraintValidator implements ContainerAwareInterface
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
        if (in_array($entity->getType(), array('weeklytask'))) {
            if (($user = $this->container->get('user')->current())) {
                $entityManager = $this->container->get('entity_manager');
                $repositoryReminderUserItem = $entityManager->getRepository('Fitbase\Bundle\ReminderBundle\Entity\ReminderUserItem');
                if (($collection = $repositoryReminderUserItem->findAllByUserAndType($user, $entity->getType()))) {
                    if (count($collection) >= 3) {
                        $this->context->addViolation($constraint->message, array());
                        return false;
                    }
                }
            }
        }

        return true;
    }
}