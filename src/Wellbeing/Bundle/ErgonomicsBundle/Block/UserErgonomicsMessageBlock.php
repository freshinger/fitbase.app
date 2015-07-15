<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Wellbeing\Bundle\ErgonomicsBundle\Block;


use Application\Sonata\ClassificationBundle\Entity\Category;
use Doctrine\Common\Collections\Collection;
use Fitbase\Bundle\ExerciseBundle\Event\ExerciseEvent;
use Fitbase\Bundle\FitbaseBundle\Library\Block\BaseFitbaseBlock;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserErgonomicsMessageBlock extends BaseFitbaseBlock implements ContainerAwareInterface
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
     * Get array with roles, for this block
     * @return mixed
     */
    function getRoles()
    {
        return array(
            'ROLE_FITBASE_USER'
        );
    }

    /**
     * Define
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'template' => 'Wellbeing/Ergonomics/Block/ErgonomicsMessage.html.twig',
        ));
    }

    /**
     * Render block response
     * @param string $view
     * @param array $parameters
     * @param Response $response
     * @return Response
     */
    public function renderResponse($view, array $parameters = array(), Response $response = null)
    {

        return $this->getTemplating()->renderResponse($view, array(), $response);
    }


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Ergonomics message (Wellbeing)';
    }
}