<?php
namespace Fitbase\Bundle\QuestionnaireBundle\Command;

use Fitbase\Bundle\AufgabeBundle\Event\WeeklyTaskEvent;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\Event;

class QuestionnairePlannerCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('fitbase:questionnaire:planner')
            ->setDescription('Questionnaire planner command, fill planning table by user data');
    }

    /**
     * Create weekly tasks planning for all users
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $logger = $this->getContainer()->get('logger');
        $logger->info('Questionnaire, start planner');

        $managerEntity = $this->getContainer()->get('entity_manager');

        $repositoryCompany = $managerEntity->getRepository('Fitbase\Bundle\CompanyBundle\Entity\Company');
        $repositoryUserMeta = $managerEntity->getRepository('Ekino\WordpressBundle\Entity\UserMeta');

        // Check is company found and
        // questionnaire enabled for this company
        if (($collectionCompanies = $repositoryCompany->findBy(array('questionnaire' => true)))) {
            foreach ($collectionCompanies as $company) {
                // Try to find users, associated
                // with selected company
                if (($collectionUserMeta = $repositoryUserMeta->findBy(array('key' => 'user_company_id', 'value' => $company->getId())))) {
                    foreach ($collectionUserMeta as $userMeta) {

                        // Run planning process for user and company
                        $eventUserCompanyQuestionnaire = new Event();
                        $eventUserCompanyQuestionnaire->user = $userMeta->getUser();
                        $eventUserCompanyQuestionnaire->company = $company;

                        $this->getContainer()->get('event_dispatcher')->dispatch('questionnaire_company_plan', $eventUserCompanyQuestionnaire);
                    }
                }
            }
        }

        $logger->info('Questionnaire, end planner');
    }

}