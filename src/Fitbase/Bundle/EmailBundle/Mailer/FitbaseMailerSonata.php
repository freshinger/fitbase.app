<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fitbase\Bundle\EmailBundle\Mailer;

use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Mailer\MailerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @author Christophe Coevoet <stof@notk.org>
 */
class FitbaseMailerSonata extends FitbaseMailerUser implements MailerInterface
{
    protected $router;
    protected $twig;
    protected $parameters;

    /**
     * Extended constructor
     *
     * @param $kernel
     * @param \Swift_Mailer $mailer
     * @param UrlGeneratorInterface $router
     * @param \Twig_Environment $twig
     * @param array $parameters
     */
    public function __construct($kernel, \Swift_Mailer $mailer, LoggerInterface $logger, UrlGeneratorInterface $router, \Twig_Environment $twig, array $parameters)
    {
        parent::__construct($kernel, $mailer, $logger);

        $this->router = $router;
        $this->twig = $twig;
        $this->parameters = $parameters;
    }

    /**
     * Send confirmation message to user
     * @param UserInterface $user
     */
    public function sendConfirmationEmailMessage(UserInterface $user)
    {
        $template = $this->parameters['template']['confirmation'];
        $url = $this->router->generate('fos_user_registration_confirm', array('token' => $user->getConfirmationToken()), true);
        $context = array(
            'user' => $user,
            'confirmationUrl' => $url
        );

        $this->sendMessage($user, $template, $context, $this->parameters['from_email']['confirmation']);
    }

    /**
     * Send user reset password email
     * @param UserInterface $user
     */
    public function sendResettingEmailMessage(UserInterface $user)
    {
        $template = $this->parameters['template']['resetting'];
        $url = $this->router->generate('fos_user_resetting_reset', array('token' => $user->getConfirmationToken()), true);
        $context = array(
            'user' => $user,
            'confirmationUrl' => $url
        );
        $this->sendMessage($user, $template, $context, $this->parameters['from_email']['resetting']);
    }

    /**
     * @param UserInterface $user
     * @param $templateName
     * @param $context
     * @param $from
     */
    protected function sendMessage(UserInterface $user, $templateName, $context, $from)
    {
        $template = $this->twig->loadTemplate($templateName);
        $subject = $template->renderBlock('subject', $context);
        $htmlBody = $template->renderBlock('body_html', $context);

        return $this->mail($user, $subject, $htmlBody, $from);
    }
}
