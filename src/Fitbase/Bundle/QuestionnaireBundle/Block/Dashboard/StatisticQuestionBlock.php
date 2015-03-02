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


class StatisticQuestionBlock extends SecureBlockService
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
     * Set defaults
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'question' => null,
            'template' => 'FitbaseQuestionnaireBundle:Block:dashboard/question.html.twig',
        ));
    }

    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function executeSecure(BlockContextInterface $blockContext, Response $response = null)
    {
        $statistics = array();

        if (($question = $blockContext->getSetting('question'))) {
            if (($answers = $question->getAnswers())) {
                $statistics = $this->toDiagramData($answers, $question);
            }
        }

        return $this->renderPrivateResponse($blockContext->getSetting('template'), array(
            'question' => $question,
            'statistics' => $statistics
        ));
    }

    /**
     * @param $collection
     * @param $question
     * @return array
     */
    protected function toDiagramData($collection, $question)
    {
        $statistics = array();

        foreach ($collection as $answer) {
            $statistics[$answer->getName()] = 0;
        }

        if (($user = $this->serviceUser->current()) and ($company = $user->getCompany())) {

            if (($userAnswers = $this->objectManager->findAllByCompanyAndQuestion($company, $question))) {
                foreach ($userAnswers as $userAnswer) {
                    if (($answers = $userAnswer->getAnswers())) {
                        foreach ($answers as $answer) {
                            if (!array_key_exists($answer->getName(), $statistics)) {
                                $statistics[$answer->getName()] = 0;
                            }
                            $statistics[$answer->getName()]++;
                        }
                    }
                }
            }
        }

        if (array_sum($statistics) <= 0) {
            foreach ($collection as $answer) {
                $statistics[$answer->getName()] = 1;
            }
        }

        return $statistics;
    }


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Statistic question (Questionnaire)';
    }
} 