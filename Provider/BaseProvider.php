<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */

namespace IDCI\Bundle\SimpleMediaBundle\Provider;

use IDCI\Bundle\SimpleMediaBundle\Entity\Media;

/**
 * BaseProvider
 */
abstract class BaseProvider implements ProviderInterface
{
    public function getFormType()
    {
        $reflection = new \ReflectionClass($this);
        $name = str_replace('Provider', '', $reflection->getName());
        $classTypeName = sprintf('IDCI\Bundle\SimpleMediaBundle\Form\Type\%sType', $name);

        return new $classTypeName;
    }
}
