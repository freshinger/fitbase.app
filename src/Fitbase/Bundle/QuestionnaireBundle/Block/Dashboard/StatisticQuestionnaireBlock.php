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
use Symfony\Component\Security\Core\SecurityContextInterface;


class StatisticQuestionnaireBlock extends SecureBlockService
{
    protected $serviceUser;
    protected $objectManager;

    public function __construct($name, array $roles = array(), EngineInterface $templating, SecurityContextInterface $securityContext, $serviceUser, QuestionnaireUserManagerInterface $objectManager)
    {
        parent::__construct($name, $roles, $templating, $securityContext);
        $this->serviceUser = $serviceUser;
        $this->objectManager = $objectManager;
    }

    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function executeSecure(BlockContextInterface $blockContext, Response $response = null)
    {
        $statistic = array(
            'done' => 0,
            'pause' => 1,
        );

        $questionnaire = null;
        if (($user = $this->serviceUser->current()) and ($company = $user->getCompany())) {
            if (($companyQuestionnaire = $company->getQuestionnaire())) {

//                if (($collection = $this->objectManager->findAllFirstByCompanyQuestionnaire($company, $companyQuestionnaire))) {
//                    $statistic = $this->toPieData($collection, $company->getActioncodes());
//                }
            }
        }

        return $this->renderPrivateResponse('FitbaseQuestionnaireBundle:Block:dashboard/questionnaire.html.twig', array(
            'statistic' => $statistic,
            'questionnaire' => $questionnaire
        ));
    }


    /**
     * Transform data from database to pie data
     *
     * @param $collection
     * @return array
     */
    protected function toPieData($questionnaries, $actioncodes)
    {
        $statistic = array(
            'done' => 0,
            'pause' => 0,
        );

        foreach ($actioncodes as $actioncode) {
            $statistic['pause']++;
        }

        foreach ($questionnaries as $element) {
            if ($element->getDone()) {
                $statistic['done']++;
                $statistic['pause']--;
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