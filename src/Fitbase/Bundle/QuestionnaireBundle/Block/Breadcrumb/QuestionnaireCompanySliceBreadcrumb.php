<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 06/11/14
 * Time: 16:11
 */

namespace Fitbase\Bundle\QuestionnaireBundle\Block\Breadcrumb;

use Fitbase\Bundle\FitbaseBundle\Block\Breadcrumb\FitbaseBreadcrumbBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class QuestionnaireCompanySliceBreadcrumb extends QuestionnaireCompanyBreadcrumb
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'fitbase.breadcrumb.questionnaire.company.slice';
    }

    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    protected function getMenu(BlockContextInterface $blockContext)
    {
        $menu = parent::getMenu($blockContext);

        if (($user = $this->container->get('user')->current())) {
            $unique = $this->container->get('request')->get('unique');
            $entityManager = $this->container->get('entity_manager');
            $repositoryQuestionnaire = $entityManager->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireCompany');
            if (($questionnaireCompany = $repositoryQuestionnaire->findOneByUniqueAndCompany($unique, $user->getCompany()))) {

                $menu->addChild($questionnaireCompany->getQuestionnaire()->getQuestionnaire()->getName(), array(
                    'route' => 'questionnaire_statistic_slice',
                    'routeParameters' => array(
                        'unique' => $this->container->get('request')->get('unique')
                    )
                ));
            }
        }


        return $menu;
    }
} 