<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\CompanyBundle\Block;


use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

class CompanyHeaderBlockService extends BaseBlockService implements ContainerAwareInterface
{
    /**
     * Store container here
     * @var
     */
    protected $container;

    /**
     * Set container
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }


    /**
     * Get company by slug
     *
     * @param null $slug
     * @return mixed
     */
    protected function getCompanyBySlug($slug = null)
    {
        $entityManager = $this->container->get('entity_manager');
        $repositoryCompany = $entityManager->getRepository('Fitbase\Bundle\CompanyBundle\Entity\Company');
        return $repositoryCompany->findOneBySlug($slug);
    }

    /**
     * Get company from user
     *
     * @param null $user
     * @return null
     */
    protected function getCompanyByUser($user = null)
    {
        if (is_object($user)) {
            return $user->getCompany();
        }
        return null;
    }

    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $request = $this->container->get('request');

        $slug = null;
        if (!($slug = $request->get('company', null))) {
            if (!($slug = $request->cookies->get('company'))) {
                // TODO:
            }
        }

        if (!($company = $this->getCompanyBySlug($slug))) {
            if (($user = $this->container->get('user')->current())) {
                if (!($company = $this->getCompanyByUser())) {
                    // TODO:
                }
            }
        }

        return $this->renderPrivateResponse('FitbaseCompanyBundle:Block:header.html.twig', array(
            'company' => $company,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Header (Company)';
    }
} 