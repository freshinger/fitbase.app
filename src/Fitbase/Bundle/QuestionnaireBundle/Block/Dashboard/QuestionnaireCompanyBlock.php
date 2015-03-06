<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\QuestionnaireBundle\Block\Dashboard;


use Fitbase\Bundle\CompanyBundle\Entity\CompanyQuestionnaire;
use Fitbase\Bundle\CompanyBundle\Form\CompanyQuestionnaireForm;
use Fitbase\Bundle\FitbaseBundle\Block\SecureBlockServiceAbstract;
use Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireCompany;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;


class QuestionnaireCompanyBlock extends SecureBlockServiceAbstract
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
            'template' => 'FitbaseQuestionnaireBundle:Block:dashboard/questionnaire_company.html.twig',
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

            $repositoryQuestionnaireCompany = $this->objectManager->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireCompany');
            return $this->renderPrivateResponse($blockContext->getSetting('template'), array(
                'form' => $form->createView(),
                'questionnaires' => $repositoryQuestionnaireCompany->findBy(array(
                    'company' => $company,
                )),
            ));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Dashboard (Questionnaire company)';
    }
} 