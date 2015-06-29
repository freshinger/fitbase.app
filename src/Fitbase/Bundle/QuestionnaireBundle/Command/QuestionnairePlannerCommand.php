<?php
namespace Fitbase\Bundle\QuestionnaireBundle\Command;

use Fitbase\Bundle\AufgabeBundle\Event\WeeklyTaskEvent;
use Fitbase\Bundle\FitbaseBundle\Library\Command\SafeCommand;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\Event;

class QuestionnairePlannerCommand extends SafeCommand
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
    protected function doExecuteSafe(InputInterface $input, OutputInterface $output)
    {
        $managerEntity = $this->getContainer()->get('entity_manager');
        $repositoryQuestionnaireCompany = $managerEntity->getRepository('Fitbase\Bundle\QuestionnaireBundle\Entity\QuestionnaireCompany');

        if (($datetime = $this->getContainer()->get('datetime')->getDateTime('now'))) {
            if (($questionnairesCompanies = $repositoryQuestionnaireCompany->findAllNotProcessedByDate($datetime))) {
                foreach ($questionnairesCompanies as $questionnaireCompany) {

                    $this->getContainer()->get('sonata.notification.backend')
                        ->createAndPublish('fitbase.questionnaire_company', array(
                            'questionnaireCompany' => $questionnaireCompany,
                        ));

                    $output->writeln($questionnaireCompany->getCompany()->getName());
                }
            }
        }
    }
}