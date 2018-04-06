<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 */

namespace IDCI\Bundle\SimpleMediaBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;

/**
 * YoutubeMediaType.
 */
class YoutubeMediaType extends MediaType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('name', null, array(
                'required' => true,
                'label' => 'Youtube URL',
            ))
            ->remove('description')
        ;
    }

    public function getName()
    {
        return 'idcisimplemediabundle_youtubemediatype';
    }
}
