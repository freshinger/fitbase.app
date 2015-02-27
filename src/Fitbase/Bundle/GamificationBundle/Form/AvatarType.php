<?php
/**
 * Created by PhpStorm.
 * User: sensey
 * Date: 8/14/14
 * Time: 9:46 AM
 */

namespace Fitbase\Bundle\GamificationBundle\Form;


use Doctrine\ORM\EntityRepository;
use Fitbase\Bundle\GamificationBundle\Form\DataTransformer\AvatarDataTransformer;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AvatarType extends AbstractType
{

    protected $templating;
    protected $gamification;

    public function __construct($templating, $gamification)
    {
        $this->templating = $templating;
        $this->gamification = $gamification;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new AvatarDataTransformer($this->templating);
        $builder->addModelTransformer($transformer);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);
        $view->vars['monkey'] = $this->gamification->getSvgMonkey();
        $view->vars['bear'] = $this->gamification->getSvgBear();
        $view->vars['deer'] = $this->gamification->getSvgDeer();
        $view->vars['crane'] = $this->gamification->getSvgCrane();
        $view->vars['tiger'] = $this->gamification->getSvgTiger();
    }

    /**
     * Set default options for this type
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'label' => false,
        ));
    }

    /**
     * Get parent element
     * @return null|string|\Symfony\Component\Form\FormTypeInterface
     */
    public function getParent()
    {
        return 'hidden';
    }

    /**
     * Get element name for templater
     * @return string
     */
    public function getName()
    {
        return 'avatar';
    }
}