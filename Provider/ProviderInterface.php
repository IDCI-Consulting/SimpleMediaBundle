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
     * Get the media public url
     *
     * @param Media $media
     * @return string
     */
    function getPublicUrl(Media $media);

    /**
     * @param Media $media
     * @return array
     */
    function getMetadata(Media $media);

    /**
     * @return string
     */
    function getFormType();

    /**
     * @param Media $media
     * @return boolean
     */
    function isTransformable(Media $media);

    /**
     * @param Media $media
     * @return boolean
     */
    function transform(Media $media);

    /**
     * @param Media $media
     * @return void
     */
    function remove(Media $media);

    /**
     * @return string
     */
    function getName();
}
