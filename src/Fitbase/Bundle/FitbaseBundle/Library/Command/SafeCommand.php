<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 24/06/15
 * Time: 10:29
 */

namespace Fitbase\Bundle\FitbaseBundle\Library\Command;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class SafeCommand extends LockCommand
{
    /**
     * Execute command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {

            $this->lockTask($this->getName());

            $this->doExecuteSafe($input, $output);

        } catch (CommandLockedException $ex) {

            $this->get('logger')->err($ex->getMessage());
            $output->writeln($ex->getMessage());

            return;

        } catch (\Exception $ex) {
            $output->writeln($ex->getMessage());
            $this->get('logger')->crit($ex->getMessage());
        }

        $this->unlockTask();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed
     */
    abstract protected function doExecuteSafe(InputInterface $input, OutputInterface $output);

}