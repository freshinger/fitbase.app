<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\CompanyBundle\Block;

use Fitbase\Bundle\CompanyBundle\Service\ServiceCompanyInterface;
use Fitbase\Bundle\FitbaseBundle\Block\SecureBlockServiceAbstract;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


abstract class CompanyUserLimitedBlockAbstract extends SecureBlockServiceAbstract implements CompanyBlockInterface
{
    /**
     * Service company
     * @var
     */
    protected $company;

    /**
     * Set service company
     * @param ServiceCompanyInterface $serviceCompany
     * @return $this
     */
    public function setServiceCompany(ServiceCompanyInterface $serviceCompany)
    {
        $this->company = $serviceCompany;
        return $this;
    }

    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        if (($company = $this->company->current())) {
            // Check count user and acceptable
            // limit for current company,
            if (count($company->getUsers()) >= $company->getUserLimit()) {
                return parent::execute($blockContext, $response);
            }
            // Does not display
            // a statistic if not enough users
            return $this->lock($blockContext, $response);
        }

        throw new AccessDeniedException('This user does not have access to this section.');
    }


    /**
     * @param BlockContextInterface $blockContext
     * @param Response $response
     * @return mixed
     */
    abstract function lock(BlockContextInterface $blockContext, Response $response = null);
}