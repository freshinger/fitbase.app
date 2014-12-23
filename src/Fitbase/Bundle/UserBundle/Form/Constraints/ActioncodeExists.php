<?php
namespace Fitbase\Bundle\UserBundle\Form\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ActioncodeExists extends Constraint
{
    public $message = 'This actioncode was not found';

    public function validatedBy()
    {
        return 'actioncode_exists';
    }
}