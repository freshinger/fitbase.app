<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Wellbeing\Bundle\ApiBundle\Block;


use Fitbase\Bundle\FitbaseBundle\Block\SecureBlockServiceAbstract;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;


class UserStateLiveBlock extends BaseBlockService
{
    /**
     * Set defaults
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'template' => 'Wellbeing/UserState/Block/UserStateLive.html.twig',
        ));
    }

    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function renderResponse($view, array $parameters = array(), Response $response = null)
    {

        return $this->getTemplating()->renderResponse($view, $parameters, $response);
    }


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Wellbeing (User state live)';
    }
} 