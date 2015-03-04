<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 15/10/14
 * Time: 11:14
 */
namespace Fitbase\Bundle\UserBundle\Block\Dashboard;


use Fitbase\Bundle\FitbaseBundle\Block\SecureBlockService;
use Fitbase\Bundle\FitbaseBundle\Service\ServiceUser;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\BlockServiceInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;


class StatisticUserStressBlock extends SecureBlockService
{
    protected $objectManager;

    public function __construct($name, array $roles = array(), EngineInterface $templating, SecurityContextInterface $securityContext, $objectManager)
    {
        parent::__construct($name, $roles, $templating, $securityContext);
        $this->objectManager = $objectManager;
    }

    /**
     * Set defaults
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'slug' => null,
            'company' => null,
            'template' => 'FitbaseUserBundle:Block:dashboard/user_stress.html.twig',
        ));
    }

    /**
     * Draw a block
     * {@inheritdoc}
     */
    public function executeSecure(BlockContextInterface $blockContext, Response $response = null)
    {

        $countTotal = 1;
        $countCategory = 0;
        $category = null;
        if (($company = $blockContext->getSetting('company'))) {
            $countTotal = count($company->getUsers());

            $repositoryCategory = $this->objectManager->getRepository('Application\Sonata\ClassificationBundle\Entity\Category');

            if (($category = $repositoryCategory->findOneBySlug($blockContext->getSetting('slug')))) {

                if (($users = $company->getUsers())) {
                    foreach ($users as $user) {
                        if (($assessment = $user->getAssessment($company->getQuestionnaire()))) {
                            if (($answers = $assessment->getAnswers())) {
                                foreach ($answers as $answer) {
                                    if (($question = $answer->getQuestion())) {

                                        if (($question->hasCategory($category))) {
                                            if ($question->hasProblem($answer->getCountPoint())) {
                                                $countCategory += 1;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $this->renderPrivateResponse($blockContext->getSetting('template'), array(
            'category' => $category,
            'percent' => (float)$countCategory / $countTotal,
        ));
    }


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Dashboard (User focus statistic)';
    }
} 