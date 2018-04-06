<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 */

namespace IDCI\Bundle\SimpleMediaBundle\Form\Type;

use IDCI\Bundle\SimpleMediaBundle\Entity\AssociatedMedia;
use IDCI\Bundle\SimpleMediaBundle\Entity\Media;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * MediaAssociableType.
 */
class MediaAssociableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $em = $options['em'];
        $hash = $options['hash'];

        $reflection = new \ReflectionClass($options['mediaAssociable']);
        $label = $reflection->getShortName();

        $builder
            ->add('mediaAssociable', $options['mediaAssociableType'], array(
                'property_path' => false,
                'label' => $label,
                'data' => $options['mediaAssociable'],
            ))
        ;

        $associatedMedias = $em
            ->getRepository('IDCISimpleMediaBundle:AssociatedMedia')
            ->findBy(array('hash' => $hash))
        ;

        foreach ($associatedMedias as $associatedMedia) {
            $fieldName = sprintf('associatedMedia_%d', $associatedMedia->getId());
            $builder
                ->add($fieldName, new AssociatedMediaType(), array(
                    'property_path' => false,
                    'required' => false,
                    'data' => $associatedMedia,
                    'em' => $em,
                ))
            ;
        }

        $provider = $options['provider'];
        $media = new Media();
        $media->setProviderName($provider->getName());
        $associatedMedia = new AssociatedMedia();
        $associatedMedia->setHash($hash);
        $associatedMedia->setMedia($media);

        $builder
            ->add('associatedMedia', new AssociatedMediaType(), array(
                'property_path' => false,
                'required' => false,
                'data' => $associatedMedia,
                'em' => $em,
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'cascade_validation' => true,
            'mediaAssociableType' => null,
            'mediaAssociable' => null,
            'provider' => null,
        ));

        $resolver->setRequired(array(
            'mediaAssociableType',
            'mediaAssociable',
            'provider',
            'hash',
            'em',
        ));

        $resolver->setAllowedTypes(array(
            'mediaAssociableType' => 'Symfony\Component\Form\AbstractType',
            'mediaAssociable' => 'IDCI\Bundle\SimpleMediaBundle\Entity\MediaAssociableInterface',
            'provider' => 'IDCI\Bundle\SimpleMediaBundle\Provider\ProviderInterface',
            'hash' => 'string',
            'em' => 'Doctrine\Common\Persistence\ObjectManager',
        ));
    }

    public function getName()
    {
        return 'idcisimplemediabundle_associatedmediatype';
    }
}
