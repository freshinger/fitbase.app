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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class FooterBlock extends BaseBlockService
{
    protected $serviceCompany;

    /**
     * @param string $name
     * @param EngineInterface $templating
     * @param $serviceCompany
     */
    public function __construct($name, EngineInterface $templating, $serviceCompany)
    {
        parent::__construct($name, $templating);

        $this->serviceCompany = $serviceCompany;
    }

    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        return $this->renderPrivateResponse('Company/Block/Footer.html.twig', array(
            'company' => $this->serviceCompany->current(),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Footer (Company)';
    }
} 