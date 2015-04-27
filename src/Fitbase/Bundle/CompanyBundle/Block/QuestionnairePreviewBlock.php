<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\CompanyBundle\Block;


use Fitbase\Bundle\CompanyBundle\Form\CompanyQuestionnaireForm;
use Fitbase\Bundle\FitbaseBundle\Block\SecureBlockServiceAbstract;
use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireCompany;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;


class QuestionnairePreviewBlock extends SecureBlockServiceAbstract
{
    protected $formFactory;
    protected $serviceUser;
    protected $objectManager;

    public function __construct($name, array $roles = array(), EngineInterface $templating, SecurityContextInterface $securityContext, $serviceUser, $objectManager, $formFactory, $request)
    {
        parent::__construct($name, $roles, $templating, $securityContext);
        $this->formFactory = $formFactory;
        $this->serviceUser = $serviceUser;
        $this->objectManager = $objectManager;
        $this->request = $request;
    }

    /**
     * Set defaults
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'template' => 'Company/Block/QuestionnairePreview.html.twig',
        ));
    }


    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function render(BlockContextInterface $blockContext, Response $response = null)
    {
        if (($user = $this->serviceUser->current()) and ($company = $user->getCompany())) {

            $repositoryCompanyQuestionnaire = $this->objectManager->getRepository('Fitbase\Bundle\CompanyBundle\Entity\CompanyQuestionnaire');
            if (!($collection = $repositoryCompanyQuestionnaire->findByCompany($company))) {
                $collection = array();
            }

            return $this->renderPrivateResponse($blockContext->getSetting('template'), array(
                'collection' => $collection,
            ));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Dashboard (Company-Questionnaire)';
    }
} 