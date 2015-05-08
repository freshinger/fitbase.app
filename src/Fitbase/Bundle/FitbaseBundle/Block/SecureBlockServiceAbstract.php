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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;


abstract class SecureBlockServiceAbstract extends BaseBlockService
{
    protected $roles;
    protected $securityContext;

    public function __construct($name, array $roles = array(), EngineInterface $templating, SecurityContextInterface $securityContext)
    {
        parent::__construct($name, $templating);

        $this->roles = $roles;
        $this->securityContext = $securityContext;
    }

    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        foreach ($this->roles as $role) {
            if ($this->securityContext->isGranted($role)) {
                return $this->render($blockContext, $response);
            }
        }

        throw new AccessDeniedException('This user does not have access to this section.');
    }

    /**
     * @param BlockContextInterface $blockContext
     * @param Response $response
     * @return mixed
     */
    abstract function render(BlockContextInterface $blockContext, Response $response = null);
}