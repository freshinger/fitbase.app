<?php
namespace Fitbase\Bundle\WeeklytaskBundle\Command;

use Fitbase\Bundle\WeeklytaskBundle\Event\WeeklyTaskEvent;
use Fitbase\Bundle\UserBundle\Event\UserEvent;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class WeeklyTaskExtractCommand extends ContainerAwareCommand
{
    /**
     * Configure task to extract
     * texts and images
     */
    protected function configure()
    {
        $this->setName('fitbase:weeklytask:extract')
            ->setDescription('Extract weekly task from database and save to var/extract/weeklytask');
    }


    /**
     * Clean name
     * @param $name
     * @return string
     */
    protected function clean($name)
    {
        $search = array(" ", "\n", "\t", ",", "-", "/", "\\");
        $replace = array("_", "_", "_", "_", "_", "_", "_", "_",);

        return strtolower(str_replace($search, $replace, $name));
    }

    /**
     * Create weekly tasks planning for all users
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $managerUser = $this->getContainer()->get('fitbase_manager.user');
        $repositoryWeeklytask = $this->getContainer()->get('fitbase_entity_manager')
            ->getRepository('Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask');

        $repositoryPost = $this->getContainer()->get('fitbase_entity_manager')
            ->getRepository('Ekino\WordpressBundle\Entity\Post');

        $filesystem = new Filesystem();

        if (($collection = $repositoryWeeklytask->findAll())) {
            foreach ($collection as $weeklytask) {

                if (($nameWeeklytask = $this->clean($weeklytask->getName()))) {

                    $pathRoot = $this->getContainer()->get('kernel')->getRootDir()
                        . '/../var/weeklytask/'
                        . $nameWeeklytask;

                    if (!$filesystem->exists($pathRoot)) {
                        $filesystem->mkdir($pathRoot);
                    }

                    file_put_contents("$pathRoot/name.txt", $weeklytask->getName());
                    file_put_contents("$pathRoot/description.txt", $weeklytask->getDescription());
                    file_put_contents("$pathRoot/category.txt", $weeklytask->getCategory());
                    file_put_contents("$pathRoot/week.txt", $weeklytask->getWeekId());
                    file_put_contents("$pathRoot/point.txt", $weeklytask->getCountPoint());

                    $pathRootImage = "$pathRoot/image";
                    if (!$filesystem->exists($pathRootImage)) {
                        $filesystem->mkdir($pathRootImage);
                    }

                    if (($postId = $weeklytask->getPostId())) {
                        if (($post = $repositoryPost->find($postId))) {

                            file_put_contents("$pathRoot/content.txt", strip_tags($post->getContent()));

                            $doc = \phpQuery::newDocument($post->getContent());
                            pq('img')->each(function ($element) use ($pathRootImage) {

                                if (($url = pq($element)->attr('src'))) {
                                    if (($imageContent = file_get_contents($url))) {
                                        $filename = substr($url, strrpos($url, "/") + 1);
                                        file_put_contents("$pathRootImage/$filename", $imageContent);
                                    }
                                }
                            });
                        }
                    }

                    $output->writeln($pathRoot);
                }

            }

        }

    }

}