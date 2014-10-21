<?php

namespace Fitbase\Bundle\UserBundle\Form;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;


class ImportForm extends AbstractType implements ContainerAwareInterface
{

    /**
     * Store container here
     * @var
     */
    protected $container;

    /**
     * Set container to class
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Convert internal role config to
     * choice array
     * @return array
     */
    protected function getRoles()
    {
        $result = array();
        if (($roles = $this->container->get('fitbase_wordpress.api')->wpGetOption('ors_user_roles'))) {
            foreach ($roles as $code => $role) {
                $result[$code] = $role['name'];
            }
        }
        return $result;
    }


    /**
     * Build form
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('file', 'file', array(
            'label' => "Csv-Datei",
            'required' => true,
            'attr' => array(
                'style' => 'border: 0px',
            ),))
            ->add('company', new \Fitbase\Bundle\CompanyBundle\Form\CompanyType(), array(
                'label' => "Unternehmen",
                'required' => false
            ))
            ->add('role', 'choice', array(
                'label' => "Rolle",
                'required' => false,
                'empty_value' => false,
                'choices' => $this->getRoles(),
            ))
            ->add('text', 'textarea', array(
                'label' => "Email-Text",
                'required' => false
            ))
            ->add('attach1', 'file', array(
                'label' => "Dateianhang",
                'required' => false,
                'attr' => array(
                    'style' => 'border: 0px',
                ),))
            ->add('attach2', 'file', array(
                'label' => "Dateianhang",
                'required' => false,
                'attr' => array(
                    'style' => 'border: 0px',
                ),))
            ->add('attach3', 'file', array(
                'label' => "Dateianhang",
                'required' => false,
                'attr' => array(
                    'style' => 'border: 0px',
                ),))
            ->add('save', 'submit', array(
                'label' => 'Benutzer anlegen',
                'attr' => array(
                    'class' => 'button button-primary',
                ),
            ));

    }

    public function getParent()
    {
        return 'form';
    }

    public function getName()
    {
        return 'import';
    }
}