<?php
namespace Wellbeing\Bundle\ErgonomicsBundle\Helper;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Wellbeing\Bundle\ErgonomicsBundle\Entity\UserErgonomicsMessage;

class ErgonomicsHelper extends \Twig_Extension
{
    protected $translator;

    public function __construct($translator)
    {
        $this->translator = $translator;
    }

    /**
     * Get extension functions associations
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('ergonomics_message_title', array($this, 'getErgonomicsMessageTitle')),
            new \Twig_SimpleFunction('ergonomics_message_text', array($this, 'getErgonomicsMessageText')),

        );
    }

    /**
     * Convert ergonomics message to string
     *
     * @param UserErgonomicsMessage $message
     * @return string
     */
    public function getErgonomicsMessageTitle(UserErgonomicsMessage $message = null)
    {
        if (!is_null($message)) {
            if (true === $message->getCorrect()) {
                return $this->translator->trans('ergonomics.message_correct_title', [], 'WellbeingErgonomicsBundle');
            }

            if (false === $message->getCorrect()) {
                return $this->translator->trans('ergonomics.message_wrong_title', [], 'WellbeingErgonomicsBundle');
            }
        }


        return $this->translator->trans('ergonomics.message_none_title', [], 'WellbeingErgonomicsBundle');
    }

    /**
     * Convert ergonomics message to string
     *
     * @param UserErgonomicsMessage $message
     * @return string
     */
    public function getErgonomicsMessageText(UserErgonomicsMessage $message = null)
    {
        if (!is_null($message)) {
            if (true === $message->getCorrect()) {
                return $this->translator->trans('ergonomics.message_correct', [], 'WellbeingErgonomicsBundle');
            }

            if (false === $message->getCorrect()) {
                return $this->translator->trans('ergonomics.message_wrong', [], 'WellbeingErgonomicsBundle');
            }
        }

        return $this->translator->trans('ergonomics.message_none', [], 'WellbeingErgonomicsBundle');
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'wellbeing_ergonomics_extension';
    }
}