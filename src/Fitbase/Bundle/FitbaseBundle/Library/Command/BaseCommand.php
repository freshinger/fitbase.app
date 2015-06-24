<?php
/*
 * (c) Andreas Stürz <as @ inotronic.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace Fitbase\Bundle\FitbaseBundle\Library\Command;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

/**
 * Base Class for Andeman console commands to extend from.
 * @author as
 */
abstract class BaseCommand extends ContainerAwareCommand
{

    protected $start_time;
    protected $stop_time;
    protected $execution_time;
    protected $max_time = false;
    protected $min_time = false;
    
    protected $memory_usage = false; 
    protected $my_allowed_output_tags = array('info', 'comment', 'question', 'error');
    
    
    /**
     * Starts the internal Timer
     */
    public function startTimer()
    {
        $this->start_time = microtime(true);
    }

    /**
     * Stop the internal Timer 
     * 
     * @throws \LogicException
     */
    protected function stopTimer()
    {
        if (!$this->start_time)
            throw new \LogicException('Timer was not started');
        
        $this->stop_time = microtime(true);

        $this->execution_time = $this->stop_time - $this->start_time;

        // set min_time
        if ($this->execution_time < $this->min_time || !$this->min_time) {
            $this->min_time = $this->execution_time;
        }

        // set max _time
        if ($this->execution_time > $this->max_time || !$this->max_time) {
            $this->max_time = $this->execution_time;
        }

    }

    /**
     * Get the internal Timer duration as formatted String
     * @return string Time in Format hh:mm:ss
     */
    public function getTimer()
    {
        $this->stopTimer();
        return $this->sec_to_his($this->execution_time);
    }

    /**
     * Get the internal Timer duration in seconds
     * @return float seconds rounded up to 2 decimals (0.00) 
     */
    public function getTimerSeconds()
    {
        $this->stopTimer();
        return round($this->execution_time, 2);
    }

    /**
     * Get the min. duration from all internal Timers as formatted String
     * @return string Time in Format hh:mm:ss
     */
    public function getMinTimer()
    {
        return $this->sec_to_his($this->min_time);
    }

    /**
     * Get the max. duration from all internal Timers as formatted String
     * @return string Time in Format hh:mm:ss
     */
    public function getMaxTimer()
    {
        return $this->sec_to_his($this->max_time);
    }

    /**
     * Get the min. duration from all internal Timers in seconds
     * @return float seconds rounded up to 2 decimals (0.00) 
     */
    public function getMinTimerSeconds()
    {
    	return round($this->min_time, 2);
    }

    /**
     * Get the max. duration from all internal Timers in seconds
     * @return float seconds rounded up to 2 decimals (0.00) 
     */
    public function getMaxTimerSeconds()
    {
        return round($this->max_time, 2);
    }


    /**
     * prints the Execution time
     * @param OutputInterface $output
     * @param string $tag a given Output Tag
     */
    public function echoExecutionTime(OutputInterface $output, $tag = 'comment')
    {
    	$this->check_output_tag($tag);
    	$output->writeln(
            sprintf('<%s>Execution Time: %s (%s seconds)</%s>', $tag, $this->getTimer(), $this->getTimerSeconds(), $tag)
    	);
    }
    
    
    /**
     * Get the current Memory Usage autoformatted
     * 
     * @return string Memory Usage in (b, kb, mb)
     */
    public function getMemoryUsage()
    {
    	$result = '';
    	
    	$mem_usage = memory_get_usage(true);
    	 
    	if ($mem_usage < 1024)
    		$result = $mem_usage." bytes";
    	elseif ($mem_usage < 1048576)
            $result = round($mem_usage/1024, 2)." kilobytes";
    	else
            $result = round($mem_usage/1048576, 2)." megabytes";
    	
    	return $result;
    }
    
   
    /**
     * Prints the current Memory Usage autformatted
     * 
     * @param Symfony\Component\Console\Output\OutputInterface $output 
     * @param string $tag Tag for output (info|comment|question|error)
     * 
     * @throws \LogicException
     */
    public function echoMemoryUsage(OutputInterface $output, $tag = 'comment')
    {
    	$this->check_output_tag($tag);
    	$output->writeln(
            sprintf('<%s>MEMORY Consumption: %s</%s>', $tag, $this->getMemoryUsage(), $tag)
    	);
    }
    
    
    /**
     * Checks if given Output Tag is valid
     * 
     * @param string $tag a given Output Tag
     * @throws \LogicException
     */
    protected function check_output_tag($tag)
    {
    	if(!in_array($tag, $this->my_allowed_output_tags))
            throw new \LogicException('This Tag is not allowed. Allowed Tags are: '.join(',', $this->my_allowed_output_tags));
    }
    
    /**
     * Formats Seconds to string with format hh:mm:ss
     *
     * @param integer $seconds The Seconds to Format
     * @return string the formated Time
     */
    protected function sec_to_his($seconds)
    {
    	return gmdate('H:i:s', $seconds);
    }
    
    

}
