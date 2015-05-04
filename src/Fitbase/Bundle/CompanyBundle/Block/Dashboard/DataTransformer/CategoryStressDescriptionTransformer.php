<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\CompanyBundle\Block\Dashboard\DataTransformer;


use Application\Sonata\ClassificationBundle\Entity\Category;
use Fitbase\Bundle\CompanyBundle\Block\AbstractUserLimitedBlock;
use Fitbase\Bundle\CompanyBundle\Block\CompanyBlockInterface;
use Fitbase\Bundle\CompanyBundle\Block\CompanyUserLimitedBlockAbstract;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class CategoryStressDescriptionTransformer extends CategoryDescriptionTransformerAbstract
{
    /**
     * Define config for Stress category
     * @return array
     */
    protected function getConfig()
    {
        return array(
            ((4 * 100 / 4)) => "In Ihrem Unternehmen scheinen die Mitarbeiter ständig Belastung durch Stress zu empfinden. " .
                "Sprechen Sie uns gerne an, um mehr über ergänzende Maßnahmen zur Stressbewältigung für Ihre Mitarbeiter zu erfahren.",
            ((3.5 * 100 / 4)) => "In Ihrem Unternehmen scheinen die Mitarbeiter häufig bis sehr häufig Belastung durch Stress zu empfinden. " .
                "Sprechen Sie uns gerne an, um mehr über ergänzende Maßnahmen zur Stressbewältigung für Ihre Mitarbeiter zu erfahren.",
            ((3 * 100 / 4)) => "In Ihrem Unternehmen scheinen die Mitarbeiter häufig Belastung durch Stress zu empfinden. Sprechen " .
                "Sie uns gerne an, um mehr über ergänzende Maßnahmen zur Stressbewältigung für Ihre Mitarbeiter zu erfahren.",
            ((2.5 * 100 / 4)) => "In Ihrem Unternehmen scheinen die Mitarbeiter manchmal bis häufig Belastung durch Stress zu empfinden. " .
                "Sprechen Sie uns gerne an, um mehr über ergänzende Maßnahmen zur Stressbewältigung für Ihre Mitarbeiter zu erfahren.",
            ((2 * 100 / 4)) => "In Ihrem Unternehmen scheinen die Mitarbeiter selten bis manchmal Belastung durch Stress zu empfinden." .
                "Sprechen Sie uns gerne an, um mehr über ergänzende Maßnahmen zur Stressbewältigung für Ihre Mitarbeiter zu erfahren.",
            ((1.5 * 100 / 4)) => "In Ihrem Unternehmen scheinen die Mitarbeiter selten Belastung durch Stress zu empfinden.",
            ((1 * 100 / 4)) => "In Ihrem Unternehmen scheinen die Mitarbeiter keine Belastung durch Stress zu empfinden oder nur sehr selten.",
            ((0.5 * 100 / 4)) => "In Ihrem Unternehmen scheinen die Mitarbeiter keine Belastung durch Stress zu empfinden.",
        );
    }
}