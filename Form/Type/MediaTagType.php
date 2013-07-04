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
use IDCI\Bundle\SimpleMediaBundle\Form\DataTransformer\TagsToTextTransformer;

class MediaTagType extends AbstractType
{
    protected $manager;

    public function __construct($manager)
    {
        $this->manager = $manager;
    }

    public function getManager()
    {
        return $this->manager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->appendClientTransformer(new TagsToTextTransformer($this->getManager()));
    }

    public function getParent()
    {
        return 'text';
    }
 
    public function getName()
    {
        return 'media_tag';
    }
}
