<?php
namespace Fitbase\Bundle\WeeklytaskBundle\Form\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class WeeklyquizUserAnswer extends Constraint
{
    public $message = 'Die Antwort ist falsch.';

    public function validatedBy()
    {
        return 'weeklytask_user_answer';
    }
}