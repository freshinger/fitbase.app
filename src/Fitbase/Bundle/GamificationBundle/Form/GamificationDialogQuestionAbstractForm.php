<?php

namespace Fitbase\Bundle\GamificationBundle\Form;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GamificationDialogQuestionAbstractForm extends AbstractType
{
    /**
     * Get Choice for start field
     * @return array
     */
    protected function getChoiceStart()
    {
        return array(
            0 => 'Keine Startfrage',
            1 => 'Eine Startfrage',
        );
    }

    /**
     * @return array
     */
    protected function getChoiceType()
    {
        return array(
            'boolean' => 'Ja/Nein-Antwort und neue Frage stellen',
            'text' => 'Text-Antwort und neue Frage stellen',
            'notice' => 'Text oder Video anzeigen und neue Frage stellen',
            'trash' => 'Papierkorb anzeigen  und neue Frage stellen',
            'feedback' => 'Glücktext anzeigen und neue Frage stellen',
            'finish' => 'Text anzeigen und das Gespräch beenden',
        );
    }


    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fitbase\Bundle\GamificationBundle\Entity\GamificationDialogQuestion'
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @throws \Exception
     * @return string The name of this type
     */
    public function getName()
    {
        throw new \Exception('FOrm name habe to be defined');
    }
}
