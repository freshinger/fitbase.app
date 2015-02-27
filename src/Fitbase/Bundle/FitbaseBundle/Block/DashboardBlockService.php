<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\FitbaseBundle\Block;


use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\BlockServiceInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class DashboardBlockService extends BaseBlockService
{
    protected $config;
    protected $securityContainer;

    public function __construct($name, EngineInterface $templating, array $config = array(), $securityContainer)
    {
        parent::__construct($name, $templating);

        $this->config = $config;
        $this->securityContainer = $securityContainer;
    }

    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $content = null;
        // List all records in config like
        // ROLE_USER => BlockService
        foreach ($this->config as $role => $block) {
            // check access rights for current user to
            // this block and
            if ($this->securityContainer->isGranted($role)) {
                // render a first block
                // user rights have to
                if ($block instanceof BlockServiceInterface) {
                    return $block->execute($blockContext, $response);
                }
            }
        }

        if (!empty($content)) {
            return $response->setContent($content);
        }

        throw new AccessDeniedException('This user does not have access to this section.');
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Dashboard';
    }
} 