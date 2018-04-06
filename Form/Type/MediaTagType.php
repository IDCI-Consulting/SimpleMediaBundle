<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 */

namespace IDCI\Bundle\SimpleMediaBundle\Form\Type;

use IDCI\Bundle\SimpleMediaBundle\Form\DataTransformer\TagsToTextTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type as Type;
use Symfony\Component\Form\FormBuilderInterface;

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
        return Type\TextType::class;
    }

    public function getName()
    {
        return 'media_tag';
    }
}
