<?php
namespace Fitbase\Bundle\ReminderBundle\Form\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ReminderUserItemCount extends Constraint
{
    public $message = 'Die Anzahl der Reminders is bei 3 begrenzt.';

    public function validatedBy()
    {
        return 'reminder_user_item_count';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}