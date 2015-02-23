<?php
namespace Fitbase\Bundle\ExerciseBundle\Form\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * @Annotation
 */
class FeedingUserItemsValidator extends ConstraintValidator implements ContainerAwareInterface
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
        $total = 0;
        if (($collection = $entity->getItems())) {
            foreach ($collection as $item) {
                $total += $item->getCount();
            }
        }

        if ($total <= 0) {
            $this->context->addViolation($constraint->message, array(
                'total' => $total
            ));
        }
    }
}