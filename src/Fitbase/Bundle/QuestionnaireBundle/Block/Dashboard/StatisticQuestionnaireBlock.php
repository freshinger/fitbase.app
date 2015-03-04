<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\QuestionnaireBundle\Block\Dashboard;


use Fitbase\Bundle\FitbaseBundle\Block\SecureBlockService;
use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUserManagerInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;


class StatisticQuestionnaireBlock extends SecureBlockService
{
    protected $serviceUser;

    public function __construct($name, array $roles = array(), EngineInterface $templating, SecurityContextInterface $securityContext, $serviceUser)
    {
        parent::__construct($name, $roles, $templating, $securityContext);
        $this->serviceUser = $serviceUser;
    }

    /**
     * Set defaults
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'template' => 'FitbaseQuestionnaireBundle:Block:dashboard/questionnaire.html.twig',
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
        if (($user = $this->serviceUser->current()) and (($company = $user->getCompany()))) {
            if (($questionnaire = $company->getQuestionnaire())) {
                if (($users = $company->getUsers()) and ($codes = $company->getActioncodes())) {
                    $statistic = $this->getStatistics($questionnaire, $company->getUsers(), $company->getActioncodes());
                }
            }
        }

        return $this->renderPrivateResponse($blockContext->getSetting('template'), array(
            'statistic' => $statistic,
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