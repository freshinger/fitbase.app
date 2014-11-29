<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\WeeklytaskBundle\Block;


use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class WeeklytaskDashboardBlockService extends BaseBlockService
{
    protected $serviceUser;
    protected $serviceEntityManager;

    /**
     * Constructor
     * @param string $name
     * @param EngineInterface $templating
     * @param ContainerAwareInterface $user
     */
    public function __construct($name, EngineInterface $templating, ContainerAwareInterface $serviceUser, $serviceEntityManager)
    {
        parent::__construct($name, $templating);

        $this->serviceUser = $serviceUser;
        $this->serviceEntityManager = $serviceEntityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        if (!($user = $this->serviceUser->current())) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $countWeeklytaskDone = 0;
        $countWeeklytaskPointDone = 0;

        $weeklytaskUserRepository = $this->serviceEntityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser');
        $weeklyquizUserRepository = $this->serviceEntityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser');
        $weeklyquizUserAnswerRepository = $this->serviceEntityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUserAnswer');

        $countWeeklytaskDone += $weeklytaskUserRepository->findCountByUserAndDone($user);
        $countWeeklytaskPointDone += $weeklytaskUserRepository->findSumPointByUserAndDone($user);
        $countWeeklytaskPointDone += $weeklyquizUserRepository->findSumPointByUserAndDone($user);
        $countWeeklytaskPointDone += $weeklyquizUserAnswerRepository->findSumPointByUser($user);

        $collectionWeeklytaskActual = $weeklytaskUserRepository->findAllByUserAndNotDone($user);
        $collectionWeeklytaskArchive = $weeklytaskUserRepository->findAllByUserAndDone($user);

        return $this->renderPrivateResponse('FitbaseWeeklytaskBundle:Block:dashboard.html.twig', array(
            'countWeeklytaskDone' => $countWeeklytaskDone,
            'countWeeklytaskPointDone' => $countWeeklytaskPointDone,
            'collectionWeeklytaskActual' => $collectionWeeklytaskActual,
            'collectionWeeklytaskArchive' => $collectionWeeklytaskArchive,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Dashboard (Wochenaufgaben)';
    }
} 