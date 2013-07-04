<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 *
 */

namespace IDCI\Bundle\SimpleMediaBundle\Provider;

use IDCI\Bundle\SimpleMediaBundle\Entity\Media;

/**
 * BaseProvider
 */
abstract class BaseProvider implements ProviderInterface
{
    protected $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function getFormType()
    {
        $reflection = new \ReflectionClass($this);
        $name = str_replace('Provider', '', $reflection->getShortName());
        $classTypeName = sprintf('IDCI\Bundle\SimpleMediaBundle\Form\Type\%sMediaType', $name);

        return new $classTypeName;
    }

    /**
     * @param Media $media
     * @return boolean
     */
    public function transform(Media $media)
    {
        if(!$this->isTransformable($media)) {
            return false;
        }

        return $this->doTransform($media);
    }

    /**
     * @param Media $media
     * @return boolean
     */
    abstract public function doTransform(Media $media);

    /**
     * @param Media $media
     * @return array
     */
    public function getMetadata(Media $media)
    {
        return array();
    }
}
