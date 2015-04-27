<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\CompanyBundle\Block\Dashboard;


use Fitbase\Bundle\CompanyBundle\Block\AbstractUserLimitedBlock;
use Fitbase\Bundle\CompanyBundle\Block\CompanyBlockInterface;
use Fitbase\Bundle\CompanyBundle\Block\CompanyUserLimitedBlockAbstract;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class UserFocusBlock extends CompanyUserLimitedBlockAbstract implements CompanyBlockInterface
{
    /**
     * Set defaults
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'template_default' => 'Company/Block/Dashboard/UserFocus.html.twig',
            'template_locked' => 'Company/Block/Dashboard/UserFocusLocked.html.twig',
        ));
    }

    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function render(BlockContextInterface $blockContext, Response $response = null)
    {
        $categories = null;
        if (($company = $this->company->current())) {
            if (($categories = $company->getCategories())) {
                $categories = $categories->toArray();
                uasort($categories, function ($category1, $category2) {
                    if ($category1->getCountUser() > $category2->getCountUser()) {
                        return -1;
                    }
                    return 1;
                });
            }
        }

        return $this->renderPrivateResponse($blockContext->getSetting('template_default'), array(
            'categories' => $categories,
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
        return $this->renderPrivateResponse($blockContext->getSetting('template_locked'), array());
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Dashboard (User focus statistic)';
    }
}