<?php
namespace Fitbase\Bundle\UserBundle\Form\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * @Annotation
 */
class UserPasswordValidator extends ConstraintValidator implements ContainerAwareInterface
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
        $user = $this->container->get('user')->current();
        $wordpress = $this->container->get('fitbase_wordpress.api');
        if (!$wordpress->wpCheckPassword($entity, $user->getPassword())) {
            $this->context->addViolation($constraint->message, array());
            return false;
        }

        return true;
    }
}