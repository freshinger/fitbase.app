<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\CompanyBundle\Block;


use Fitbase\Bundle\CompanyBundle\Entity\CompanyQuestionnaire;
use Fitbase\Bundle\CompanyBundle\Form\CompanyQuestionnaireForm;
use Fitbase\Bundle\FitbaseBundle\Block\SecureBlockServiceAbstract;
use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireCompany;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;


class CompanyQuestionnaireBlock extends SecureBlockServiceAbstract
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
            'company' => null,
            'template' => 'FitbaseCompanyBundle:Block:questionnaire.html.twig',
        ));
    }


    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function executeSecure(BlockContextInterface $blockContext, Response $response = null)
    {
        if (($user = $this->serviceUser->current()) and ($company = $user->getCompany())) {

            $entity = new QuestionnaireCompany();
            $entity->setCompany($company);
            $entity->setProcessed(false);

            $form = $this->formFactory->create(new CompanyQuestionnaireForm($company), $entity);
            if ($this->request->get($form->getName())) {
                $form->handleRequest($this->request);
                if ($form->isValid()) {

                    $this->objectManager->persist($entity);
                    $this->objectManager->flush($entity);
                }
            }

            $repositoryCompanyQuestionnaire = $this->objectManager->getRepository('Fitbase\Bundle\CompanyBundle\Entity\CompanyQuestionnaire');
            if (!($questionnairesAvailable = $repositoryCompanyQuestionnaire->findByCompany($company))) {
                $questionnairesAvailable = array();
            }

            $repositoryQuestionnaireCompany = $this->objectManager->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireCompany');
            if (!($questionnairesProcessed = $repositoryQuestionnaireCompany->findByCompany($company))) {
                $questionnairesProcessed = array();
            }

            return $this->renderPrivateResponse($blockContext->getSetting('template'), array(
                'form' => $form->createView(),
                'questionnairesAvailable' => $questionnairesAvailable,
                'questionnairesProcessed' => $questionnairesProcessed,
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