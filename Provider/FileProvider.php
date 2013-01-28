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
 * FileProvider
 */
class FileProvider extends BaseProvider
{
    /**
     * @param IDCI\Bundle\SimpleMediaBundle\Entity\Media $media
     *
     * @return string
     */
    protected function generateReferenceName(Media $media)
    {
        return sha1($media->getName() . rand(11111, 99999)) . '.' . $media->getBinaryContent()->guessExtension();
    }
}
