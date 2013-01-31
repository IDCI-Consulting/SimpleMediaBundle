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
use IDCI\Bundle\SimpleMediaBundle\Form\DataTransformer\TagsToListTransformer;

/**
 * AssociatedMediaType
 */
class AssociatedMediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entityManager = $options['em'];
        $transformer = new TagsToListTransformer($entityManager);

        $reflection = new \ReflectionClass($options['mediaAssociable']);
        $label = $reflection->getShortName();
        $provider = $options['provider'];

        $builder
            ->add('mediaAssociable', $options['mediaAssociableType'], array(
                'label'         => $label,
                'property_path' => false,
            ))
            ->add('media', $provider->getFormType())
            ->add(
                $builder->create('tags', 'text', array('required' => false))
                    ->addModelTransformer($transformer)
            )
            ->add('provider', 'hidden', array(
                'data'          => $provider->getName(),
                'property_path' => false,
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'          => 'IDCI\Bundle\SimpleMediaBundle\Entity\AssociatedMedia',
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
