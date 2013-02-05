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
    public function __construct()
    {
        $this->name = "file";
    }

    /**
     * @param Media $media
     * @return string
     */
    public function generateReferenceName(Media $media)
    {
        return sha1($media->getBinaryContent()->getClientOriginalName() . rand(11111, 99999)) . '.' . $media->getBinaryContent()->guessExtension();
    }

    /**
     * Get the full path to the media root directory
     *
     * @return string
     */
    public function getMediaRootDir()
    {
         return __DIR__.'/../../../../../../../web/'.$this->getUploadDir();
    }

    /**
     * Get the media directory
     *
     * @return string
     */
    public function getUploadDir()
    {
        return 'uploads/media';
    }

    /**
     * Get the media root path
     *
     * @param Media $media
     * @return string
     */
    public function getMediaPath(Media $media)
    {
        return sprintf('%s/%s',
            $this->getMediaRootDir(),
            $media->getProviderReference()
        );
    }

    /**
     * @param Media $media
     * @return string
     */
    public function getPublicUrl(Media $media)
    {
        return sprintf('%s/%s',
            $this->getUploadDir(),
            $media->getProviderReference()
        );
    }

    /**
     * @param Media $media
     * @return boolean
     */
    public function isTransformable(Media $media)
    {
        return $media->getBinaryContent() ? true : false;
    }

    /**
     * @param Media $media
     * @return boolean
     */
    public function doTransform(Media $media)
    {
        try {
            $media->getBinaryContent()->move($this->getMediaRootDir(), $media->getProviderReference());
        } catch(FileException $e) {
            return false;
        }

        $media->setName($media->getBinaryContent()->getClientOriginalName());
        $media->setSize($media->getBinaryContent()->getClientSize());
        $media->setContentType($media->getBinaryContent()->getClientMimeType());

        list($width, $height) = getimagesize($this->getMediaPath($media));
        $media->setWidth($width);
        $media->setHeight($height);

        return true;
    }

    /**
     * @param Media $media
     * @return void
     */
    public function remove(Media $media)
    {
        unlink($this->getMediaPath($media));
    }
}
