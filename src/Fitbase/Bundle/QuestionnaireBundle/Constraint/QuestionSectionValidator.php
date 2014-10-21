<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/22/14
 * Time: 3:00 PM
 */

namespace Fitbase\Bundle\QuestionnaireBundle\Constraint;


use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraints\Range;


class QuestionSectionValidator extends ConstraintValidator implements ContainerAwareInterface
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
        $id = 6;
        if (isset($value[$id]) and (($value6 = $value[$id]))) {
            $errorList6 = $this->container->get('validator')->validateValue($value6, new Range(array(
                'min' => 0,
                'max' => 28,
                'minMessage' => 'Bitte geben Sie an, an wie vielen Tagen Sie innerhalb der letzten 4 Wochen Rückenschmerzen hatten.',
                'maxMessage' => 'Bitte geben Sie an, an wie vielen Tagen Sie innerhalb der letzten 4 Wochen Rückenschmerzen hatten.',
            )));

            $errorList6Iterator = $errorList6->getIterator();
            while ($errorList6Iterator->valid()) {
                $this->context->addViolation($errorList6Iterator->current());
                $errorList6Iterator->next();
            }
        }

        $id = 7;
        if (isset($value[$id]) and ($value7 = $value[$id])) {
            $errorList7 = $this->container->get('validator')->validateValue($value7, new Range(array(
                'min' => 80,
                'max' => 230,
                'minMessage' => 'Bitte geben Sie Ihre Größe in Zentimetern an.',
                'maxMessage' => 'Bitte geben Sie Ihre Größe in Zentimetern an.',
            )));

            $errorList7Iterator = $errorList7->getIterator();
            while ($errorList7Iterator->valid()) {
                $this->context->addViolation($errorList7Iterator->current());
                $errorList7Iterator->next();
            }
        }

        $id = 8;
        if (isset($value[$id]) and ($value8 = $value[$id])) {
            $errorList8 = $this->container->get('validator')->validateValue($value8, new Range(array(
                'min' => 30,
                'max' => 230,
                'minMessage' => 'Bitte geben Sie Ihr Gewicht in Kilogramm an.',
                'maxMessage' => 'Bitte geben Sie Ihr Gewicht in Kilogramm an.',
            )));

            $errorList8Iterator = $errorList8->getIterator();
            while ($errorList8Iterator->valid()) {
                $this->context->addViolation($errorList8Iterator->current());
                $errorList8Iterator->next();
            }
        }

        if (!count($this->context->getViolations())) {
            return true;
        }

        return false;
    }
}