<?php
namespace Fitbase\Bundle\UserBundle\Form\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * @Annotation
 */
class ActioncodeUsedValidator extends ConstraintValidator implements ContainerAwareInterface
{

    protected $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function validate($value, Constraint $constraint)
    {
        $entityManager = $this->container->get('entity_manager');
        $repositoryUser = $entityManager->getRepository('Fitbase\Bundle\UserBundle\Entity\UserActioncode');

        $options = array(
            'code' => $value,
            'processed' => true,
        );

        if (($actioncode = $repositoryUser->findOneBy($options))) {
            $this->context->addViolation($constraint->message, array());
            return false;
        }

        return true;
    }
}