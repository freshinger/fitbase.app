<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\CompanyBundle\Block\Dashboard;


use Application\Sonata\ClassificationBundle\Entity\Category;
use Fitbase\Bundle\CompanyBundle\Block\AbstractUserLimitedBlock;
use Fitbase\Bundle\CompanyBundle\Block\CompanyUserLimitedBlockAbstract;
use Fitbase\Bundle\FitbaseBundle\Block\SecureBlockServiceAbstract;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class CompanyUserCategoryBlock extends CompanyUserLimitedBlockAbstract
{
    /**
     * Set defaults
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'slug' => null,
            'company' => null,
            'template_default' => 'FitbaseCompanyBundle:Block:Dashboard/user_category.html.twig',
            'template_locked' => 'FitbaseCompanyBundle:Block:Dashboard/user_category_locked.html.twig',
        ));
    }

    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function render(BlockContextInterface $blockContext, Response $response = null)
    {
        $category = null;
        $questionCount = 0;
        $categoryCountPointTotal = 0;
        $categoryCountPointUser = 0;

        if (($company = $blockContext->getSetting('company'))) {
            if (($companyCategory = $company->getCategoryBySlug($blockContext->getSetting('slug')))) {

                if (($category = $companyCategory->getCategory())) {
                    if (($users = $company->getUsers()) and ($countTotal = count($users))) {
                        foreach ($users as $user) {
                            if (($assessment = $user->getAssessment($company->getQuestionnaire()))) {
                                if (($userAnswers = $assessment->getAnswers())) {
                                    foreach ($userAnswers as $userAnswer) {
                                        if (($question = $userAnswer->getQuestion())) {
                                            if (($question->hasCategory($category))) {
                                                $questionCount += 1;
                                                $categoryCountPointTotal += $question->getCountPointMax();
                                                $categoryCountPointUser += $userAnswer->getCountPoint();
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $percent = 0;
        if ($categoryCountPointTotal > 0) {
            $percent = (100 - ($categoryCountPointUser * 100 / $categoryCountPointTotal));
        }

        return $this->renderPrivateResponse($blockContext->getSetting('template_default'), array(
            'category' => $category,
            'percent' => $percent,
            'description' => $this->getDescription($category, $percent),
        ));
    }

    /**
     * Display locked block
     * @param BlockContextInterface $blockContext
     * @param Response $response
     * @return mixed|Response
     */
    public function lock(BlockContextInterface $blockContext, Response $response = null)
    {
        $category = null;
        if (($company = $blockContext->getSetting('company'))) {
            if (($companyCategory = $company->getCategoryBySlug($blockContext->getSetting('slug')))) {
                $category = $companyCategory->getCategory();
            }
        }

        return $this->renderPrivateResponse($blockContext->getSetting('template_locked'), array(
            'category' => $category
        ));
    }

    /**
     * Get description by category and percent
     * @param $category
     * @param $percent
     * @return null|void
     */
    protected function getDescription($category, $percent)
    {
        if ($category instanceof Category) {
            if ($category->getSlug() == 'ruecken') {
                return $this->getDescriptionBack($percent);
            }
            if ($category->getSlug() == 'stress') {
                return $this->getDescriptionStress($percent);
            }
        }
        return null;
    }

    /**
     * Get description for back-category
     * @param $percent
     * @return string
     */
    protected function getDescriptionBack($percent)
    {
        $pointsMax = 4;
        $pointsMin = 3.5;

        if ((100 - ($pointsMin * 100 / 4)) > $percent and $percent >= (100 - ($pointsMax * 100 / 4))) {
            return "In Ihrem Unternehmen scheinen die Mitarbeiter ständig Rückenbeschwerden zu haben. " .
            "Sprechen Sie uns gerne an, um mehr über ergänzende Maßnahmen zur Rückengesundheit für Ihre Mitarbeiter zu erfahren.";
        }

        $pointsMax = 3.5;
        $pointsMin = 3;
        if ((100 - ($pointsMin * 100 / 4)) > $percent and $percent >= (100 - ($pointsMax * 100 / 4))) {
            return "In Ihrem Unternehmen scheinen die Mitarbeiter häufig bis sehr häufig Rückenbeschwerden zu haben. " .
            "Sprechen Sie uns gerne an, um mehr über ergänzende Maßnahmen zur Rückengesundheit für Ihre Mitarbeiter zu erfahren.";
        }

        $pointsMax = 3;
        $pointsMin = 2.5;
        if ((100 - ($pointsMin * 100 / 4)) > $percent and $percent >= (100 - ($pointsMax * 100 / 4))) {
            return "In Ihrem Unternehmen scheinen die Mitarbeiter häufig Rückenbeschwerden zu haben. " .
            "Sprechen Sie uns gerne an, um mehr über ergänzende Maßnahmen zur Rückengesundheit für Ihre Mitarbeiter zu erfahren.";
        }

        $pointsMax = 2.5;
        $pointsMin = 2;
        if ((100 - ($pointsMin * 100 / 4)) > $percent and $percent >= (100 - ($pointsMax * 100 / 4))) {
            return "In Ihrem Unternehmen scheinen die Mitarbeiter manchmal bis häufig Belastung durch Stress zu empfinden. " .
            "Sprechen Sie uns gerne an, um mehr über ergänzende Maßnahmen zur Rückengesundheit für Ihre Mitarbeiter zu erfahren.";
        }

        $pointsMax = 2;
        $pointsMin = 1.5;
        if ((100 - ($pointsMin * 100 / 4)) > $percent and $percent >= (100 - ($pointsMax * 100 / 4))) {
            return "In Ihrem Unternehmen scheinen die Mitarbeiter selten bis manchmal Rückenbeschwerden zu haben. " .
            "Sprechen Sie uns gerne an, um mehr über ergänzende Maßnahmen zur Rückengesundheit für Ihre Mitarbeiter zu erfahren.";
        }

        $pointsMax = 1.5;
        $pointsMin = 1;
        if ((100 - ($pointsMin * 100 / 4)) > $percent and $percent >= (100 - ($pointsMax * 100 / 4))) {
            return "In Ihrem Unternehmen scheinen die Mitarbeiter selten Belastung durch Rückenbeschwerden zu haben.";
        }
        $pointsMax = 1;
        $pointsMin = 0.5;
        if ((100 - ($pointsMin * 100 / 4)) > $percent and $percent >= (100 - ($pointsMax * 100 / 4))) {
            return "In Ihrem Unternehmen scheinen die Mitarbeiter keine Belastung durch Rückenbeschwerden zu haben oder nur sehr selten.";
        }


        $pointsMax = 0.5;
        $pointsMin = 0;
        if ((100 - ($pointsMin * 100 / 4)) > $percent and $percent >= (100 - ($pointsMax * 100 / 4))) {
            return "In Ihrem Unternehmen scheinen die Mitarbeiter keine Belastung durch Rückenbeschwerden zu haben.";
        }
    }

    /**
     * Get text descriptions for stress
     * @param $percent
     * @return string
     */
    protected function getDescriptionStress($percent)
    {
        $pointsMax = 4;
        $pointsMin = 3.5;

        if ((100 - ($pointsMin * 100 / 4)) > $percent and $percent >= (100 - ($pointsMax * 100 / 4))) {
            return "In Ihrem Unternehmen scheinen die Mitarbeiter ständig Belastung durch Stress zu empfinden. " .
            "Sprechen Sie uns gerne an, um mehr über ergänzende Maßnahmen zur Stressbewältigung für Ihre Mitarbeiter zu erfahren.";
        }

        $pointsMax = 3.5;
        $pointsMin = 3;
        if ((100 - ($pointsMin * 100 / 4)) > $percent and $percent >= (100 - ($pointsMax * 100 / 4))) {
            return "In Ihrem Unternehmen scheinen die Mitarbeiter häufig bis sehr häufig Belastung durch Stress zu empfinden. " .
            "Sprechen Sie uns gerne an, um mehr über ergänzende Maßnahmen zur Stressbewältigung für Ihre Mitarbeiter zu erfahren.";
        }

        $pointsMax = 3;
        $pointsMin = 2.5;
        if ((100 - ($pointsMin * 100 / 4)) > $percent and $percent >= (100 - ($pointsMax * 100 / 4))) {
            return "In Ihrem Unternehmen scheinen die Mitarbeiter häufig Belastung durch Stress zu empfinden. Sprechen " .
            "Sie uns gerne an, um mehr über ergänzende Maßnahmen zur Stressbewältigung für Ihre Mitarbeiter zu erfahren.";
        }

        $pointsMax = 2.5;
        $pointsMin = 2;
        if ((100 - ($pointsMin * 100 / 4)) > $percent and $percent >= (100 - ($pointsMax * 100 / 4))) {
            return "In Ihrem Unternehmen scheinen die Mitarbeiter manchmal bis häufig Belastung durch Stress zu empfinden. " .
            "Sprechen Sie uns gerne an, um mehr über ergänzende Maßnahmen zur Stressbewältigung für Ihre Mitarbeiter zu erfahren.";
        }

        $pointsMax = 2;
        $pointsMin = 1.5;
        if ((100 - ($pointsMin * 100 / 4)) > $percent and $percent >= (100 - ($pointsMax * 100 / 4))) {
            return "In Ihrem Unternehmen scheinen die Mitarbeiter selten bis manchmal Belastung durch Stress zu empfinden." .
            "Sprechen Sie uns gerne an, um mehr über ergänzende Maßnahmen zur Stressbewältigung für Ihre Mitarbeiter zu erfahren.";
        }

        $pointsMax = 1.5;
        $pointsMin = 1;
        if ((100 - ($pointsMin * 100 / 4)) > $percent and $percent >= (100 - ($pointsMax * 100 / 4))) {
            return "In Ihrem Unternehmen scheinen die Mitarbeiter selten Belastung durch Stress zu empfinden.";
        }
        $pointsMax = 1;
        $pointsMin = 0.5;
        if ((100 - ($pointsMin * 100 / 4)) > $percent and $percent >= (100 - ($pointsMax * 100 / 4))) {
            return "In Ihrem Unternehmen scheinen die Mitarbeiter keine Belastung durch Stress zu empfinden oder nur sehr selten.";
        }

        $pointsMax = 0.5;
        $pointsMin = 0;
        if ((100 - ($pointsMin * 100 / 4)) > $percent and $percent >= (100 - ($pointsMax * 100 / 4))) {
            return "In Ihrem Unternehmen scheinen die Mitarbeiter keine Belastung durch Stress zu empfinden.";
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Dashboard (User focus statistic)';
    }
} 