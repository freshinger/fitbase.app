<?php
namespace Fitbase\Bundle\ExerciseBundle\Form\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class FeedingUserItems extends Constraint
{
    public $message = 'Anzahl der Portionen kann nicht 0 sein.';

    public function validatedBy()
    {
        return 'FeedingUserItemsValidator';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}