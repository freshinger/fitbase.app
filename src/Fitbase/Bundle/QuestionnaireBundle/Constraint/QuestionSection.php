<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/22/14
 * Time: 3:00 PM
 */

namespace Fitbase\Bundle\QuestionnaireBundle\Constraint;


use Symfony\Component\Validator\Constraint;

class QuestionSection extends Constraint
{
    public $message = 'This value is not a valid email Question response.';

    /**
     * Validate by service
     * @return string
     */
    public function validatedBy()
    {
        return 'questionnaire_section';
    }
}