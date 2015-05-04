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
use Fitbase\Bundle\CompanyBundle\Block\CompanyBlockInterface;
use Fitbase\Bundle\CompanyBundle\Block\CompanyUserLimitedBlockAbstract;
use Fitbase\Bundle\CompanyBundle\Block\Dashboard\DataTransformer\CategoryBackDescriptionTransformer;
use Fitbase\Bundle\CompanyBundle\Block\Dashboard\DataTransformer\CategoryStressDescriptionTransformer;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class UserCategoryBlock extends CompanyUserLimitedBlockAbstract implements CompanyBlockInterface
{
    /**
     * Set defaults
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'slug' => null,
            'template_default' => 'Company/Block/Dashboard/UserCategory.html.twig',
            'template_locked' => 'Company/Block/Dashboard/UserCategoryLocked.html.twig',
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

        if (($company = $this->company->current())) {
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
        if (($company = $this->company->current())) {
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

            switch ($category->getSlug()) {
                case 'ruecken':
                    return (new CategoryBackDescriptionTransformer())
                        ->transform($percent);
                case 'stress';
                    return (new CategoryStressDescriptionTransformer())
                        ->transform($percent);
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Dashboard (User focus statistic)';
    }
} 