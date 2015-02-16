<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 12/02/15
 * Time: 14:39
 */
namespace Fitbase\Bundle\WeeklytaskBundle\Consumer;

use Application\Sonata\UserBundle\Entity\User;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklyquizUser;
use Fitbase\Bundle\WeeklytaskBundle\Entity\Weeklytask;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskManagerInterface;
use Fitbase\Bundle\WeeklytaskBundle\Entity\WeeklytaskUser;
use Sonata\NotificationBundle\Consumer\ConsumerEvent;
use Sonata\NotificationBundle\Consumer\ConsumerInterface;


class WeeklytaskCreatorConsumer implements ConsumerInterface
{
    protected $objectManager;
    protected $datetime;
    protected $codegenerator;

    public function __construct(WeeklytaskManagerInterface $objectManager, $datetime, $codegenerator)
    {
        $this->objectManager = $objectManager;
        $this->datetime = $datetime;
        $this->codegenerator = $codegenerator;
    }

    /**
     * Create weeklytask for user, and weeklyquiz
     * @param ConsumerEvent $event
     */
    public function process(ConsumerEvent $event)
    {
        if (($message = $event->getMessage())) {

            $user = $message->getValue('user');
            assert(($user instanceof User));

            $weeklytask = $message->getValue('weeklytask');
            assert(($weeklytask instanceof Weeklytask));

            $processed = $message->getValue('processed');
            assert(is_bool($processed));

            $date = $message->getValue('date');
            assert(($date instanceof \DateTime));

            if (!$this->objectManager->exists($user, $weeklytask)) {

                $weeklytaskUser = new WeeklytaskUser();
                $weeklytaskUser->setDone(0);
                $weeklytaskUser->setProcessed($processed);
                $weeklytaskUser->setUser($user);
                $weeklytaskUser->setDate($date);
                $weeklytaskUser->setTask($weeklytask);
                $weeklytaskUser->setCode($this->codegenerator->code(10));
                $weeklytaskUser->setCountPoint(0);

                $this->objectManager->persist($weeklytaskUser);

                if (($quiz = $weeklytask->getQuiz())) {

                    $weeklyquizUser = new WeeklyquizUser();
                    $weeklyquizUser->setDone(0);
                    $weeklyquizUser->setProcessed($processed);
                    $weeklyquizUser->setQuiz($quiz);
                    $weeklyquizUser->setUser($user);
                    $weeklyquizUser->setCountPoint(0);
                    $weeklyquizUser->setCode($this->codegenerator->password(10));
                    $weeklyquizUser->setTask($weeklytask);
                    $weeklyquizUser->setDate($date->modify('+1 day'));
                    $weeklyquizUser->setUserTask($weeklytaskUser);

                    $this->objectManager->persist($weeklyquizUser);

                    $weeklytaskUser->setUserQuiz($weeklyquizUser);

                    $this->objectManager->persist($weeklytaskUser);
                }
            }
        }
    }
}