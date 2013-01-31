<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */

namespace IDCI\Bundle\SimpleMediaBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;

/**
 * FileMediaType
 */
class FileMediaType extends MediaType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('binaryContent', 'file', array('required' => false))
        ;
    }

    public function getName()
    {
        return 'idcisimplemediabundle_filemediatype';
    }
}
