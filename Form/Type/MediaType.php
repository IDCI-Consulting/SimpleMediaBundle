<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 */

namespace IDCI\Bundle\SimpleMediaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type as Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * MediaType.
 */
abstract class MediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description')
            ->add('enabled')
            ->add('providerName', Type\HiddenType::class)
            ->add('updated_at', Type\DateTimeType::class, array(
                'data' => new \DateTime('now'),
                'attr' => array('style' => 'display:none;'),
                'label_attr' => array('style' => 'display:none;'),
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'IDCI\Bundle\SimpleMediaBundle\Entity\Media',
        ));
    }

    public function getName()
    {
        return 'idcisimplemediabundle_mediatype';
    }
}
