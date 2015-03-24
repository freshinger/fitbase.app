<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\CompanyBundle\Block\Dashboard;


use Fitbase\Bundle\FitbaseBundle\Block\SecureBlockServiceAbstract;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Templating\EngineInterface;


class CompanyUserActivityBlock extends SecureBlockServiceAbstract
{
    protected $entityManager;

    public function __construct($name, array $roles = array(), EngineInterface $templating, SecurityContextInterface $securityContext, $entityManager)
    {
        parent::__construct($name, $roles, $templating, $securityContext);
        $this->entityManager = $entityManager;
    }

    /**
     * Set defaults
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'company' => null,
            'template' => 'FitbaseCompanyBundle:Block:Dashboard/user_activity.html.twig',
        ));
    }

    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function render(BlockContextInterface $blockContext, Response $response = null)
    {
        $countUser = 0;
        $countField = 0;
        $countQuiz = 0;

        if (($company = $blockContext->getSetting('company'))) {
            $countUser = count($company->getUsers());

            $repositoryUserActivity = $this->entityManager->getRepository('Fitbase\Bundle\StatisticBundle\Entity\UserActivity');
            $countField = $repositoryUserActivity->findCountPointByCompany($company);

            $repositoryUserActivity = $this->entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser');
            $countQuiz = $repositoryUserActivity->findCountDoneByCompany($company);
        }

        return $this->renderPrivateResponse($blockContext->getSetting('template'), array(
            'countUser' => $countUser,
            'countField' => $countField,
            'countQuiz' => $countQuiz,
        ));
    }


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Dashboard (User statistic)';
    }
} 