<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/22/14
 * Time: 3:00 PM
 */

namespace Fitbase\Bundle\QuestionnaireBundle\Form\Constraint;


use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraints\Range;


class QuestionnaireQuestionValidator extends ConstraintValidator implements ContainerAwareInterface
{

    protected $container;

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Validate value
     * @param mixed $value
     * @param Constraint $constraint
     * @return bool
     */
    public function validate($value, Constraint $constraint)
    {
        if (empty($value)) {
            $this->context->addViolation('Beantworten Sie bitte die Frage');
            return false;
        }
        return true;
    }
}