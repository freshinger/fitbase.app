<?php
namespace Fitbase\Bundle\BarmerGekBundle\Form\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * @Annotation
 */
class UserSessionValidator extends ConstraintValidator implements ContainerAwareInterface
{

    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     *
     * @todo check user session and userId by barmer gek
     *
     * @param mixed $entity
     * @param Constraint $constraint
     * @return bool
     */
    public function validate($entity, Constraint $constraint)
    {
        $serviceBarmerApi = $this->container->get('barmer_gek_api');
        if ($serviceBarmerApi->sessionStatus($entity->getUnique(), $entity->getSession())) {
            return true;
        }

        $this->context->addViolation($constraint->message, array());
        return false;
    }
}