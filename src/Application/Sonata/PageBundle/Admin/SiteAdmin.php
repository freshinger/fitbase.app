<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\PageBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Admin definition for the Site class
 *
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
class SiteAdmin extends \Sonata\PageBundle\Admin\SiteAdmin
{
    protected $baseRouteName = 'fitbase_user_group';
    protected  $baseRoutePattern = 'fitbase_user_group';

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('isDefault')
            ->add('enabled', null, array('editable' => true))
            ->add('host')
            ->add('group', null, array('label' => 'Gruppe'))
            ->add('relativePath', null, array('label' => 'Pfad'))
            ->add('locale', null, array('label' => 'Sprache'))
            ->add('enabledFrom')
            ->add('enabledTo')
            ->add('create_snapshots', 'string', array('template' => 'SonataPageBundle:SiteAdmin:list_create_snapshots.html.twig'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with($this->trans('form_site.label_general'), array('class' => 'col-md-6'))
                ->add('name')
                ->add('isDefault', null, array('required' => false))
                ->add('enabled', null, array('required' => false))
                ->add('host')
                ->add('locale', 'locale', array(
                    'required' => false
                ))
                ->add('relativePath', null, array('required' => false))
                ->add('enabledFrom', 'sonata_type_datetime_picker', array('dp_side_by_side' => true))
                ->add('enabledTo', 'sonata_type_datetime_picker', array('dp_side_by_side' => true))
            ->end()
            ->with($this->trans('form_site.label_group'), array('class' => 'col-md-6'))
                ->add('group')
            ->end()
            ->with($this->trans('form_site.label_seo'), array('class' => 'col-md-6'))
                ->add('title', null, array('required' => false))
                ->add('metaDescription', 'textarea', array('required' => false))
                ->add('metaKeywords', 'textarea', array('required' => false))
            ->end()
        ;
    }
}
