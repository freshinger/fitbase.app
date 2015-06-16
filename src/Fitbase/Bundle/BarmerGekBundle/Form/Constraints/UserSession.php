<?php
namespace Fitbase\Bundle\BarmerGekBundle\Form\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UserSession extends Constraint
{
    public $message = 'Can not verify user data by Barmer Gek.';

    /**
     * @return string
     */
    public function validatedBy()
    {
        return 'barmer_gek_user_session';
    }

    /**
     * @return array|string
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}