<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 7/11/14
 * Time: 4:14 PM
 */

namespace Fitbase\Bundle\ExerciseBundle\Command;


use Fitbase\Bundle\ExerciseBundle\Event\ExerciseReminderEvent;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

class ExerciseImageReplacerCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('fitbase:exercise:image-replacer')
            ->setDescription('Replace old images from ors to real images');
    }

    /**
     * Execute task
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entityManager = $this->get('entity_manager');
        $repositoryExercise = $entityManager->getRepository('Fitbase\Bundle\ExerciseBundle\Entity\Exercise');


        $replace = array(
            '/wp-content/uploads/muskelgruppen/01_nackenmuskeln.jpg' => '/uploads/default/0001/02/thumb_1640_default_thumbnail.jpeg',
            '/wp-content/uploads/muskelgruppen/02_oberer_ruecken.jpg' => '/uploads/default/0001/02/thumb_1641_default_thumbnail.jpeg',
            '/wp-content/uploads/muskelgruppen/03_bauchmuskeln.jpg' => '/uploads/default/0001/02/thumb_1642_default_thumbnail.jpeg',
            '/wp-content/uploads/muskelgruppen/04_oberarm.jpg' => '/uploads/default/0001/02/thumb_1643_default_thumbnail.jpeg',
            '/wp-content/uploads/muskelgruppen/05_unterer_ruecken_nackenmuskeln.jpg' => '/uploads/default/0001/02/thumb_1644_default_thumbnail.jpeg',
            '/wp-content/uploads/muskelgruppen/06_unterarm.jpg' => '/uploads/default/0001/02/thumb_1645_default_thumbnail.jpeg',
            '/wp-content/uploads/muskelgruppen/07_mittlerer_ruecken.jpg' => '/uploads/default/0001/02/thumb_1646_default_thumbnail.jpeg',
            '/wp-content/uploads/muskelgruppen/08_brust.jpg' => '/uploads/default/0001/02/thumb_1647_default_thumbnail.jpeg',
            '/wp-content/uploads/muskelgruppen/09_brust_oberarm.jpg' => '/uploads/default/0001/02/thumb_1648_default_thumbnail.jpeg',
            '/wp-content/uploads/muskelgruppen/10_unterer_ruecken.jpg' => '/uploads/default/0001/02//uploads/default/0001/02/thumb_1649_default_thumbnail.jpeg',
            '/wp-content/uploads/muskelgruppen/11_oberschenkel.jpg' => '/uploads/default/0001/02/thumb_1650_default_thumbnail.jpeg',
            '/wp-content/uploads/muskelgruppen/12_oberer_und_mittlerer_ruecken.jpg' => '/uploads/default/0001/02/thumb_1651_default_thumbnail.jpeg',
            '/wp-content/uploads/muskelgruppen/13_gesamter_ruecken.jpg' => '/uploads/default/0001/02/thumb_1652_default_thumbnail.jpeg',
            '/wp-content/uploads/muskelgruppen/14_oberarm_unterarm.jpg' => '/uploads/default/0001/02/thumb_1653_default_thumbnail.jpeg',
            '/wp-content/uploads/muskelgruppen/15_oberarm_oberschenkel.jpg ' => '/uploads/default/0001/02/thumb_1654_default_thumbnail.jpeg',
        );

        foreach ($repositoryExercise->findAll() as $exercise) {
            $output->writeln($exercise->getName());
            $exercise->setDescription(str_replace(array_keys($replace), array_values($replace), $exercise->getDescription()));
            $entityManager->persist($exercise);
        }
        $entityManager->flush();
    }

    /**
     * Get service from container
     * @param $name
     * @return object
     */
    protected function get($name)
    {
        return $this->getContainer()->get($name);
    }
}