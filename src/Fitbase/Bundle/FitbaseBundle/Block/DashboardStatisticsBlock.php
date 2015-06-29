<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\FitbaseBundle\Block;


use Fitbase\Bundle\FitbaseBundle\Library\Block\BaseFitbaseBlock;
use Fitbase\Bundle\GamificationBundle\Event\WidgetEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class DashboardStatisticsBlock extends BaseFitbaseBlock
{

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
     * Get array with roles, for this block
     * @return mixed
     */
    function getRoles()
    {
        return [
            'ROLE_FITBASE_USER',
        ];
    }

    /**
     * Define
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'template' => 'Fitbase/User/Dashboard/Statistics.html.twig',
        ));
    }

    /**
     *  Render response
     *
     * @param string $view
     * @param array $parameters
     * @param Response $response
     * @return Response
     */
    public function renderResponse($view, array $parameters = array(), Response $response = null)
    {
        $event = new WidgetEvent($parameters);
        $this->container->get('event_dispatcher')->dispatch('fitbase_widget.dashboard_statistics', $event);

        if (($response = $event->getResponse())) {
            return $response;
        }

        return $this->getTemplating()->renderResponse($view, $parameters, $response);
    }


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'User statistics (Dashboard)';
    }
}