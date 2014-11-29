<?php
namespace Fitbase\Bundle\UserBundle\Form\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * @Annotation
 */
class UserEmailUniqueValidator extends ConstraintValidator implements ContainerAwareInterface
{

    protected $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }


    public function validate($entity, Constraint $constraint)
    {
        if (($user = $this->container->get('user')->findOneBy(array('email' => $entity->getEmail())))) {

            if ($user->getId() != $entity->getId()) {
                $this->context->addViolation($constraint->message, array());
                return false;
            }
        }
        return true;
    }
}