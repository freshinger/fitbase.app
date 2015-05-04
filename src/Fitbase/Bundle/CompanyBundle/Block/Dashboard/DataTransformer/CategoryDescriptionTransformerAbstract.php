<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\CompanyBundle\Block\Dashboard\DataTransformer;


use Application\Sonata\ClassificationBundle\Entity\Category;
use Fitbase\Bundle\CompanyBundle\Block\AbstractUserLimitedBlock;
use Fitbase\Bundle\CompanyBundle\Block\CompanyBlockInterface;
use Fitbase\Bundle\CompanyBundle\Block\CompanyUserLimitedBlockAbstract;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class CategoryDescriptionTransformerAbstract
{
    /**
     * Transform percent to text
     * @param $percent
     * @return null
     */
    public function transform($percent)
    {
        if (($config = $this->getConfig())) {
            if (ksort($config)) {
                $percent_cache = NULL;
                foreach ($config as $percent_max => $text) {
                    if ($percent > $percent_max) {
                        continue;
                    }
                    return $text;
                }
                return $text;
            }
        }
        return NULL;
    }
}