<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\CompanyBundle\Block;


use Fitbase\Bundle\FitbaseBundle\Block\SecureBlockServiceAbstract;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


abstract class CompanyUserLimitedBlockAbstract extends SecureBlockServiceAbstract implements ContainerAwareInterface
{
    /**
     * Container Object
     * @var
     */
    protected $container;

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        if (($company = $this->container->get('company')->current())) {
            if (($users = $company->getUsers())) {
                // Check count user and acceptable limit
                // for current company, does not display
                // a statistic if not enought users
                if ($users->count() >= $company->getUserLimit()) {
                    return parent::execute($blockContext, $response);
                }
            }
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