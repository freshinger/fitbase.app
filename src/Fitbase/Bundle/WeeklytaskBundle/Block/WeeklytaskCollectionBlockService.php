<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\WeeklytaskBundle\Block;


use Doctrine\Common\Collections\ArrayCollection;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WeeklytaskCollectionBlockService extends BaseBlockService
{
    /**
     * Weeklytask manager
     *
     * @var
     */
    protected $weeklytaskManager;

    protected $serviceUser;

    /**
     * @param string $name
     * @param EngineInterface $templating
     */
    public function __construct($name, EngineInterface $templating, $weeklytaskManager, $serviceUser)
    {
        parent::__construct($name, $templating);

        $this->serviceUser = $serviceUser;
        $this->weeklytaskManager = $weeklytaskManager;
    }

    /**
     * Define
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'categories' => array(),
            'template' => 'FitbaseWeeklytaskBundle:Block:weeklytask_collection.html.twig',
        ));
    }


    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $weeklytasks = array();
        if (($user = $this->serviceUser->current())) {
            if (($categories = $blockContext->getSetting('categories'))) {
                if (($category = $categories->first())) {
                    $weeklytasks = $this->weeklytaskManager->findAllByUserAndCategory($user, $category);
                }
            }
        }

        return $this->renderPrivateResponse($blockContext->getSetting('template'), array(
            'weeklytasks' => $weeklytasks,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Infoeinheit collection (Wochenaufgaben)';
    }
} 