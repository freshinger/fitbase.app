<?php
namespace Fitbase\Bundle\ExerciseBundle\Form\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * @Annotation
 */
class FeedingUserUniqueValidator extends ConstraintValidator implements ContainerAwareInterface
{

    protected $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }


    /**
     * Validate
     * @param mixed $entity
     * @param Constraint $constraint
     * @return bool
     */
    public function validate($entity, Constraint $constraint)
    {
        $entityManager = $this->container->get('entity_manager');
        $repositoryFeedingUser = $entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\FeedingUser');

        if ($repositoryFeedingUser->findByUserAndDate($entity->getUser(), $entity->getDate())) {
            $this->context->addViolation($constraint->message, array());
            return false;
        }
        return true;
    }
}