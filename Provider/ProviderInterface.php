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
 * ProviderInterface
 */
interface ProviderInterface
{
    /**
     * @param Media $media
     * @return string
     */
    function generateReferenceName(Media $media);

    /**
     * @return string
     */
    function getFormType();

    /**
     * @param Media $media
     */
    function transform(Media $media);
}
