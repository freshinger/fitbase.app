<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\UserBundle\Block\Dashboard;


use Fitbase\Bundle\FitbaseBundle\Block\SecureBlockServiceAbstract;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;


class StatisticUserCategoryBlock extends SecureBlockServiceAbstract
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
            'template' => 'FitbaseUserBundle:Block:dashboard/statistic/user_category.html.twig',
        ));
    }

    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function executeSecure(BlockContextInterface $blockContext, Response $response = null)
    {
        $category = null;
        $countTotal = 1;
        $countCategory = 0;

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
                                                if ($question->hasProblem($userAnswer->getCountPoint())) {
                                                    $countCategory += 1;
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
        }

        return $this->renderPrivateResponse($blockContext->getSetting('template'), array(
            'category' => $category,
            'percent' => (float)$countCategory / $countTotal,
        ));
    }


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Dashboard (User focus statistic)';
    }
} 