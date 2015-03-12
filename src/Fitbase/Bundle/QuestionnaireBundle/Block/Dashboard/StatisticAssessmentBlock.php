<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\QuestionnaireBundle\Block\Dashboard;


use Fitbase\Bundle\FitbaseBundle\Block\SecureBlockServiceAbstract;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StatisticAssessmentBlock extends SecureBlockServiceAbstract
{
    /**
     * Set defaults
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'company' => null,
            'template' => 'FitbaseQuestionnaireBundle:Block:dashboard/statistic/assessment.html.twig',
        ));
    }

    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function executeSecure(BlockContextInterface $blockContext, Response $response = null)
    {
        $statistic = array('done' => 0, 'pause' => 1);

        $questionnaire = null;
        if (($company = $blockContext->getSetting('company'))) {
            if (($questionnaire = $company->getQuestionnaire())) {
                if (($users = $company->getUsers()) and ($codes = $company->getActioncodes())) {
                    $statistic = $this->getStatistics($questionnaire, $company->getUsers(), $company->getActioncodes());
                }
            }
        }


        $done = isset($statistic['done']) ? $statistic['done'] : 0;
        $total = (isset($statistic['pause']) ? $statistic['pause'] : 0) + $done;

        return $this->renderPrivateResponse($blockContext->getSetting('template'), array(
            'percent' => (float)($done / $total * 100),
            'questionnaire' => $questionnaire
        ));
    }

    /**
     * Get statistical data
     *
     * @param null $questionnaire
     * @param null $users
     * @param null $actioncodes
     * @return array
     */
    protected function getStatistics($questionnaire, $users = null, $actioncodes = null)
    {
        $statistic = array(
            'done' => 0,
            'pause' => 0,
        );

        if (count($users)) {
            foreach ($users as $user) {
                // Get assessment questionnaire for user from company
                if (($questionnaireUser = $user->getAssessment($questionnaire))) {
                    if ($questionnaireUser->getDone()) {
                        $statistic['done']++;
                        continue;
                    }
                }
                $statistic['pause']++;
            }
        }

        // Potential users
        // mark not registered users as a
        // not processed questionnaire
        if (count($actioncodes)) {
            foreach ($actioncodes as $actioncode) {
                if (!$actioncode->getProcessed()) {
                    $statistic['pause']++;
                }
            }
        }

        if (array_sum($statistic) <= 0) {
            $statistic = array(
                'done' => 0,
                'pause' => 1,
            );
        }

        return $statistic;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Dashboard (Questionnaire Company)';
    }
} 