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
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UserFocusBlock extends BaseBlockService implements ContainerAwareInterface
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
     * Draw a block
     * TODO: create a test
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        if (!($user = $this->container->get('user')->current())) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $entityManager = $this->container->get('entity_manager');
        $weeklytaskUserRepository = $entityManager->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser');
        $collectionWeeklytaskActual = $weeklytaskUserRepository->findAllByUser($user, 5);

        $category = null;
        if (($focus = $this->container->get('focus')->focus($user))) {
            if (($focusCategory = $focus->getFirstCategory())) {
                $category = $focusCategory->getCategory();
            }
        }

        return $this->renderPrivateResponse('Gamification/Dashboard/DashboardFocus.html.twig', array(
            'user' => $user,
            'form' => ($form = $this->getAssessmentRepeatForm()) == null ? null : $form->createView(),
            'category' => $category,
            'nextWeeklytask' => $this->getNextIntervalWeeklytask($user),
            'collection' => $collectionWeeklytaskActual,
        ));
    }

    /**
     * Get assessment form view
     * @return null
     */
    protected function getAssessmentRepeatForm()
    {
        if ($this->container->get('questionnaire')->assessment()) {
            return $this->container->get('form.factory')->create(new AssessmentUserRepeatForm(), new QuestionnaireUser());
        }
        return null;
    }

    /**
     * Get next
     * @param $user
     * @return int
     */
    protected function getNextIntervalWeeklytask($user)
    {
        $dayNext = 0;
        $dayCurrent = 0;

        if (($datetime = $this->container->get('datetime')->getDateTime('now'))) {

            $current = (int)$datetime->format('N');

            $entityManager = $this->container->get('entity_manager');
            $repositoryReminderUserItem = $entityManager->getRepository('Fitbase\Bundle\ReminderBundle\Entity\ReminderUserItem');
            if (($collection = $repositoryReminderUserItem->findAllByUserAndType($user, 'weeklytask'))) {

                $next = 1;
                if (($itemFirst = $collection->first())) {
                    $next = $itemFirst->getDay();
                }

                foreach ($collection as $key => $item) {
                    if ($item->getDay() > $current) {
                        $next = $item->getDay();
                        break;
                    }
                }

                return (($diff = ($next - $current)) > 0) ? $diff : 7 + $diff;
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Dashboard Focus (Gamification)';
    }
} 