<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\GamificationBundle\Block\Dashboard;


use Fitbase\Bundle\FitbaseBundle\Library\Block\BaseFitbaseBlock;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserDocsBlock extends BaseFitbaseBlock implements containerawareinterface
{
    /**
     * store container here
     * @var
     */
    protected $container;

    /**
     * set container
     * @param containerinterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Get array with roles, for this block
     * @return mixed
     */
    function getRoles()
    {
        return [
            'ROLE_FITBASE_USER'
        ];
    }


    /**
     * Set defaults
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'template' => 'Gamification/Dashboard/UserDocs.html.twig',
        ));
    }

    /**
     * Render block response
     *
     * @param string $view
     * @param array $parameters
     * @param Response $response
     * @return Response
     */
    public function renderResponse($view, array $parameters = array(), Response $response = null)
    {
        if (!($user = $this->container->get('user')->current())) {
            throw new \LogicException('User object can not be empty');
        }

        return $this->getTemplating()->renderResponse($view, $parameters, $response);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'User documentation (Gamification dashboard)';
    }
} 