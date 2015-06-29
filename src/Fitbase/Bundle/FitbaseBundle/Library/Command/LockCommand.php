<?php
/*
 * (c) Andreas Stürz <as @ inotronic.de>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*
*/
namespace Fitbase\Bundle\FitbaseBundle\Library\Command;

use Fitbase\Bundle\FitbaseBundle\Library\Exception\CommandLockedException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOException;

/**
 * Class for Commands that needs a locking Automatism
 * @author as
 */
abstract class LockCommand extends BaseCommand
{
    protected $task_lock_file = null;

    /**
     * checks if Task is locked and writes a lockfile if not
     * @param string $name The unique Command Name e.g. demo:greet
     * @param string $optional_string A optional String that will suffix the Command Name
     */
    public function lockTask($name = null, $optional_string = null)
    {
        if (!$name) $name = $this->getName();

        $filesystem = $this->getContainer()->get('filesystem');

        // build and set lockfile name, if not configured
        if (!$this->task_lock_file) {
            $this->setLockFile($this->buildLockfileName($name, $optional_string));
        }

        // writes a lock file for a task
        if (!$this->isTaskLocked($this->getLockFile())) {

            // create dir, if not exits
            if (!$filesystem->exists($this->getLockDir())) {
                $filesystem->mkdir($this->getLockDir());
            }

            // create the lock file
            $filesystem->touch($this->getLockFile());

            // change mode so the web user can remove it if we die
            $filesystem->chmod($this->getLockFile(), $this->getLockfileChmod());

        }

    }


    /**
     * removes the Lock file for a Task
     */
    public function unlockTask()
    {
        // removes lock file for task
        $this->getContainer()->get('filesystem')->remove($this->getLockFile());
    }

    /**
     * Checks if Task is locked
     * @param file $lockfile The lockfile Name
     * @throws CommandLockedException if task is locked
     * @return boolean always return false
     */
    protected function isTaskLocked($lockfile)
    {
        // throw execption, if file exits
        if ($this->getContainer()->get('filesystem')->exists($lockfile)) {
            throw new CommandLockedException(sprintf('Task is currently locked by file: %s.', $lockfile));
        }

        return false;
    }

    /**
     * build a unique lockfile name
     * @param string $name The unique Command Name e.g. demo:greet
     * @param string $optional_string A optional String that will suffix the Command Name
     * @return string The unique Name for the lockfile
     */
    protected function buildLockfileName($name, $optional_string = null)
    {
        $result = '';
        $result .= str_replace(':', '_', $name);
        if ($optional_string) $result .= '_' . $optional_string;
        $result .= '.lck';
        return $result;
    }

    /**
     * set the Task lockfile path
     * @param file $filename
     */
    protected function setLockFile($filename)
    {
        $lockDir = $this->getLockDir();
        $this->task_lock_file = $lockDir . DIRECTORY_SEPARATOR . $filename;
    }

    /**
     * get The directory to save lockfiles
     * @return string The directory to save the lock files
     */
    protected function getLockDir()
    {
        return $this->getContainer()->get('kernel')->getRootDir() . '/locks/';
    }

    /**
     * get the chmod mode for the lockfile
     * @return int chmod mode
     */
    protected function getLockfileChmod()
    {
        return '755';
    }

    /**
     * get the current configured lockfile path
     * @throws LogicException
     * @return string The current lockfile path
     */
    protected function getLockFile()
    {
        if (!$this->task_lock_file) {
            throw new \LogicException(sprintf('No Lock filename for Task is set.'));
        }
        return $this->task_lock_file;

    }

}
