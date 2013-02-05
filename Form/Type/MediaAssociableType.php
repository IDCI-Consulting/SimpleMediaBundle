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
use IDCI\Bundle\SimpleMediaBundle\Entity\Media;

/**
 * MediaAssociableType
 */
class MediaAssociableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $reflection = new \ReflectionClass($options['mediaAssociable']);
        $label = $reflection->getShortName();

        $builder
            ->add('mediaAssociable', $options['mediaAssociableType'], array(
                'label'         => $label,
                'property_path' => false,
                'data'          => $options['mediaAssociable'],
            ))
        ;

        $provider = $options['provider'];
        $media = new Media();
        $media->setProviderName($provider->getName());

        $builder
            ->add('associatedMedia', new AssociatedMediaType(), array(
                'property_path' => false,
                'required'      => false,
                'provider'      => $provider,
                'media'         => $media,
                'em'            => $options['em'],
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'cascade_validation'  => true,
            'mediaAssociableType' => null,
            'mediaAssociable'     => null,
            'provider'            => null,
        ));

        $resolver->setRequired(array(
            'mediaAssociableType',
            'mediaAssociable',
            'provider',
            'em',
        ));

        $resolver->setAllowedTypes(array(
            'mediaAssociableType' => 'Symfony\Component\Form\AbstractType',
            'mediaAssociable'     => 'IDCI\Bundle\SimpleMediaBundle\Entity\MediaAssociableInterface',
            'provider'            => 'IDCI\Bundle\SimpleMediaBundle\Provider\ProviderInterface',
            'em'                  => 'Doctrine\Common\Persistence\ObjectManager'
        ));
    }

    public function getName()
    {
        return 'idcisimplemediabundle_associatedmediatype';
    }
}
