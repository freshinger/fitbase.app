<?php
namespace Fitbase\Bundle\UserBundle\Form\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UserEmailUnique extends Constraint
{
    public $message = 'This Email already exists.';

    public function validatedBy()
    {
        return 'user_email_unique';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}