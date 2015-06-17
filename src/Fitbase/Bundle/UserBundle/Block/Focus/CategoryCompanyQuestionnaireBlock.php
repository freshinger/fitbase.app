<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\UserBundle\Block\Focus;


use Fitbase\Bundle\FitbaseBundle\Library\Block\BaseFitbaseBlock;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoryCompanyQuestionnaireBlock extends BaseFitbaseBlock implements ContainerAwareInterface
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
            'focusCategory' => null,
            'template' => 'Company/Block/CompanyCategoryQuestionnaire.html.twig',
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
        if (!($company = $this->container->get('company')->current())) {
            throw new \LogicException('Company object can not be empty');
        }

        if (!($companyCategory = $company->getCategoryBySlug('ruecken'))) {
            throw new \LogicException('Company category object can not be empty');
        }

        
        if (($companyQuestionnaire = $companyCategory->getQuestionnaire())) {

        }


        return $this->getTemplating()->renderResponse($view, array(), $response);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Statistic question last (Questionnaire)';
    }

}