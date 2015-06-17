<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 20/05/15
 * Time: 15:27
 */
namespace Fitbase\Bundle\FitbaseBundle\Library\Block;


use Fitbase\Bundle\FitbaseBundle\Library\Interfaces\ServiceUserInterface;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
    public function setServiceUser(ServiceUserInterface $serviceUser)
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
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        throw new \LogicException('You have to define default settings here');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        if (!($roles = $this->getRoles())) {
            throw new \LogicException('You have to define roles for each fitbase-block');
        }

        if (!$this->serviceUser instanceof ServiceUserInterface) {
            throw new \LogicException('Fitbase block needs a service user interface');
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