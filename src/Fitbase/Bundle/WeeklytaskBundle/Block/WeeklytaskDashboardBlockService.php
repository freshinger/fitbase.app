<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\WeeklytaskBundle\Block;


use Fitbase\Bundle\FitbaseBundle\Block\SecureBlockServiceAbstract;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;

class WeeklytaskDashboardBlockService extends SecureBlockServiceAbstract
{

    protected $serviceUser;
    protected $serviceEntityManager;

    public function __construct($name, array $roles = array(), EngineInterface $templating, SecurityContextInterface $securityContext, $serviceUser, $serviceEntityManager)
    {
        parent::__construct($name, $roles, $templating, $securityContext);

        $this->serviceUser = $serviceUser;
        $this->serviceEntityManager = $serviceEntityManager;
    }

    /**
     * @param BlockContextInterface $blockContext
     * @param Response $response
     * @return mixed
     */
    public function render(BlockContextInterface $blockContext, Response $response = null)
    {
        if (($user = $this->serviceUser->current())) {

            $countWeeklytaskDone = 0;
            $countWeeklytaskPointDone = 0;

            $weeklytaskUserRepository = $this->serviceEntityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser');
            $weeklyquizUserRepository = $this->serviceEntityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser');

            $countWeeklytaskDone += $weeklytaskUserRepository->findCountByUserAndDone($user);
            $countWeeklytaskPointDone += $weeklytaskUserRepository->findSumPointByUserAndDone($user);
            $countWeeklytaskPointDone += $weeklyquizUserRepository->findSumPointByUserAndDone($user);

            if (!($collection = $weeklytaskUserRepository->findAllByUser($user))) {
                // TODO: statistic
            }

            return $this->renderPrivateResponse('FitbaseWeeklytaskBundle:Block:dashboard.html.twig', array(
                'countDone' => $countWeeklytaskDone,
                'countDonePoints' => $countWeeklytaskPointDone,
                'collection' => $collection,
            ));
        }

        throw new AccessDeniedException('This user does not have access to this section.');
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Dashboard (Wochenaufgaben)';
    }

}