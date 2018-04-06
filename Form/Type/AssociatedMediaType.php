<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 */

namespace IDCI\Bundle\SimpleMediaBundle\Form\Type;

use IDCI\Bundle\SimpleMediaBundle\Form\DataTransformer\TagsToListTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type as Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * AssociatedMediaType.
 */
class AssociatedMediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entityManager = $options['em'];
        $transformer = new TagsToListTransformer($entityManager);

        $provider = $options['data']->getMedia()->getProvider();

        $builder
            ->add('hash', Type\HiddenType::class)
            ->add('media', $provider->getFormType())
            ->add($builder
                ->create('tags', Type\TextType::class, array('required' => false))
                ->addModelTransformer($transformer)
            )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'IDCI\Bundle\SimpleMediaBundle\Entity\AssociatedMedia',
            'cascade_validation' => true,
        ));

        $resolver->setRequired(array(
            'em',
        ));

        $resolver->setAllowedTypes(array(
            'em' => 'Doctrine\Common\Persistence\ObjectManager',
        ));
    }

    public function getName()
    {
        return 'idcisimplemediabundle_associatedmediatype';
    }
}
