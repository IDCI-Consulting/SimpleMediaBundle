<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */

namespace IDCI\Bundle\SimpleMediaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * AssociatedMediaType
 */
class AssociatedMediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('object', $options['objectType'], array('property_path' => false))
            ->add('media', $options['mediaType'])
            ->add('tags')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'         => 'IDCI\Bundle\SimpleMediaBundle\Entity\AssociatedMedia',
            'cascade_validation' => true,
            'objectType'         => null,
            'object'             => null,
            'mediaType'          => null
        ));
    }

    public function getName()
    {
        return 'idcisimplemediabundle_associatedmediatype';
    }
}
