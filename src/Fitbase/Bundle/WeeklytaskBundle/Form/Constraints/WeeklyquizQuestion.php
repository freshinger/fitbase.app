<?php
namespace Fitbase\Bundle\WeeklytaskBundle\Form\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class WeeklyquizQuestion extends Constraint
{
    public $message = 'Die Antwort ist falsch.';

    public function validatedBy()
    {
        return 'weeklytask_question';
    }
}