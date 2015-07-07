<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\CompanyBundle\Block\Dashboard;


use Fitbase\Bundle\FitbaseBundle\Block\SecureBlockServiceAbstract;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserAssessmentBlock extends SecureBlockServiceAbstract
{
    /**
     * Set defaults
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'company' => null,
            'template' => 'Company/Block/Dashboard/UserAssessment.html.twig',
        ));
    }

    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function render(BlockContextInterface $blockContext, Response $response = null)
    {
        $done = 0;
        $total = 0;

        if (!($company = $blockContext->getSetting('company'))) {
            throw new \LogicException('Company object can not be empty');
        }

        $questionnaire = null;
        if (($questionnaire = $company->getQuestionnaire())) {
            if (($users = $company->getUsers())) {
                $total = count($users);
                foreach ($users as $user) {
                    if (($questionnaireUser = $user->getAssessment($questionnaire))) {
                        if ($questionnaireUser->getDone()) {
                            $done++;
                        }
                    }
                }
            }
        }

        return $this->renderPrivateResponse($blockContext->getSetting('template'), array(
            'percent' => (float)($done / ($total > 0 ? $total : 1) * 100),
            'questionnaire' => $questionnaire
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Dashboard (Questionnaire Company)';
    }
} 