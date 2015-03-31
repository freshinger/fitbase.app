<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\CompanyBundle\Block;


use Fitbase\Bundle\CompanyBundle\Entity\CompanyManager;
use Fitbase\Bundle\CompanyBundle\Entity\CompanyManagerInterface;
use Fitbase\Bundle\FitbaseBundle\Service\ServiceUser;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class CompanyHeaderBlock extends BaseBlockService
{
    protected $user;
    protected $session;
    protected $companyManager;

    /**
     * @param string $name
     * @param EngineInterface $templating
     * @param CompanyManagerInterface $companyManager
     * @param ServiceUser $user
     * @param SessionInterface $session
     */
    public function __construct($name, EngineInterface $templating, CompanyManagerInterface $companyManager, ServiceUser $user, SessionInterface $session)
    {
        parent::__construct($name, $templating);

        $this->user = $user;
        $this->session = $session;
        $this->companyManager = $companyManager;
    }

    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $company = null;
        if (($user = $this->user->current())) {
            if (!($company = $this->companyManager->findOneByUser($user))) {
                if (strlen(($slug = $this->session->get('company')))) {
                    $company = $this->companyManager->findOneBySlug($slug);
                }
            }
        } else {
            if (strlen(($slug = $this->session->get('company')))) {
                $company = $this->companyManager->findOneBySlug($slug);
            }
        }

        return $this->renderPrivateResponse('FitbaseCompanyBundle:Block:Header.html.twig', array(
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