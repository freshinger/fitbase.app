<?php
namespace Fitbase\Bundle\GamificationBundle\Form\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class GamificationUserDialogAnswer extends Constraint
{
    public $message = 'Beantworte bitte die Frage.';

    public function validatedBy()
    {
        return 'gamification_user_dialog_answer';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}