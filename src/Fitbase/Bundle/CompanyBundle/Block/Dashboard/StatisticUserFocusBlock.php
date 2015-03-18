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


class StatisticUserFocusBlock extends SecureBlockServiceAbstract
{
    /**
     * Set defaults
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'company' => null,
            'template' => 'FitbaseCompanyBundle:Block:Dashboard/user_focus.html.twig',
        ));
    }

    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function render(BlockContextInterface $blockContext, Response $response = null)
    {
        $categories = null;
        if (($company = $blockContext->getSetting('company'))) {
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

        return $this->renderPrivateResponse($blockContext->getSetting('template'), array(
            'categories' => $categories,
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