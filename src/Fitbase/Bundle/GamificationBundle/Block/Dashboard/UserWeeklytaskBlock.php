<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\GamificationBundle\Block\Dashboard;


use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireUser;
use Fitbase\Bundle\QuestionnaireBundle\Form\AssessmentUserRepeatForm;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UserWeeklytaskBlock extends BaseBlockService implements ContainerAwareInterface
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
     * Set defaults
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'template' => 'Gamification/Dashboard/UserWeeklytask.html.twig',
        ));
    }

    /**
     * Draw a block
     * TODO: create a test
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $user = $this->container->get('user')->current();

        $entityManager = $this->container->get('entity_manager');
        $weeklytaskUserRepository = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser');
        $collectionWeeklytaskActual = $weeklytaskUserRepository->findAllByUser($user, 4);

        return $this->renderPrivateResponse($blockContext->getSetting('template'), array(
            'collection' => $collectionWeeklytaskActual,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Weeklytasks (Gamification)';
    }
} 