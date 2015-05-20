<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 20/05/15
 * Time: 15:27
 */
namespace Fitbase\Bundle\FitbaseBundle\Library\Block;


use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseFitbaseBlock extends BaseBlockService
{
    /**
     * Store user service here
     * @var
     */
    protected $serviceUser;

    /**
     * @param $serviceUser
     * @return $this
     */
    public function setServiceUser($serviceUser)
    {
        $this->serviceUser = $serviceUser;
        return $this;
    }

    /**
     * Get array with roles, for this block
     * @return mixed
     */
    abstract function getRoles();


    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        if (!($roles = $this->getRoles())) {
            throw new \LogicException('You have to define roles for each fitbase-block');
        }

        if (($user = $this->serviceUser->current())) {
            if ($this->serviceUser->isGranted($user, $roles)) {

                return $this->renderResponse($blockContext->getTemplate(), array(
                    'block_context' => $blockContext,
                    'block' => $blockContext->getBlock(),
                ), $response);
            }
        }

        throw new AccessDeniedException('For current access to this block is denied');
    }


} 