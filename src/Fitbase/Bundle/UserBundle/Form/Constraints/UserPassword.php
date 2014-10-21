<?php
namespace Fitbase\Bundle\UserBundle\Form\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UserPassword extends Constraint
{
    public $message = 'User password is not correct.';

    public function validatedBy()
    {
        return 'fitbaseuser_password';
    }
}