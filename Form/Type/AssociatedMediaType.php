<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
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

        $provider = $options['data']->getMedia()->getProvider();

        $builder
            ->add('hash', 'hidden')
            ->add('media', $provider->getFormType())
            ->add($builder
                ->create('tags', 'text', array('required' => false))
                ->addModelTransformer($transformer)
            )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'          => 'IDCI\Bundle\SimpleMediaBundle\Entity\AssociatedMedia',
            'cascade_validation'  => true,
        ));

        $resolver->setRequired(array(
            'em',
        ));

        $resolver->setAllowedTypes(array(
            'em'                  => 'Doctrine\Common\Persistence\ObjectManager',
        ));
    }

    public function getName()
    {
        return 'idcisimplemediabundle_associatedmediatype';
    }
}
