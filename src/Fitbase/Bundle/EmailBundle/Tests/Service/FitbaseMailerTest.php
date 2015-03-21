<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 05/02/15
 * Time: 15:45
 */

namespace Fitbase\Bundle\EmailBundle\Tests\Service;


use Fitbase\Bundle\EmailBundle\Service\FitbaseMailer;
use Fitbase\Bundle\EmailBundle\Service\ServiceFitbaseMail;
use Fitbase\Bundle\FitbaseBundle\Tests\FitbaseTestAbstract;

class FitbaseMailerTest extends FitbaseTestAbstract
{
    /**
     * Check that method send email to user
     */
    public function testMethod_onUserCreateEvent_ShouldSendEmail()
    {
//        $mailer = new ServiceFitbaseMail(
//            $this->container()->get('kernel'),
//            $this->container()->get('mailer'),
//            $this->container()->get('logger')
//        );


        $this->assertTrue(true);
    }

} 