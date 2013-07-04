<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
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
        $builder
            ->add('binaryContent', 'file', array('required' => false))
        ;

        parent::buildForm($builder, $options);
    }

    public function getName()
    {
        return 'idcisimplemediabundle_filemediatype';
    }
}
