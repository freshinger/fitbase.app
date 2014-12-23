<?php
namespace Fitbase\Bundle\UserBundle\Form\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ActioncodeUsed extends Constraint
{
    public $message = 'This actioncode is already used.';

    public function validatedBy()
    {
        return 'actioncode_used';
    }
}