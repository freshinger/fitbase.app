<?php
namespace Fitbase\Bundle\ExerciseBundle\Form\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class FeedingUserUnique extends Constraint
{
    public $message = 'Für dieses Datum gibt es schon ein Eintrag.';

    public function validatedBy()
    {
        return 'FeedingUserUniqueValidator';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}