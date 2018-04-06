<?php

/**
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 */

namespace IDCI\Bundle\SimpleMediaBundle\Provider;

use IDCI\Bundle\SimpleMediaBundle\Entity\Media;

/**
 * YoutubeProvider.
 */
class YoutubeProvider extends BaseProvider
{
    const FEEDS_API_VIDEO_URL_FORMAT = 'https://gdata.youtube.com/feeds/api/videos/%s?v=2';

    public function __construct()
    {
        $this->name = 'youtube';
    }

    public function doTransform(Media $media)
    {
        $media->setProviderName($this->getName());
        $media->setProviderReference($this->generateReferenceName($media));
        $media->setProviderMetadata($this->getMetadata($media));
        $media->setName($this->getPublicUrl($media));
        $media->setAuthor($this->getAuthor($media));
        $media->setDescription($this->getDescription($media));
        $media->setContentType('application/x-shockwave-flash');

        return true;
    }

    public function generateReferenceName(Media $media)
    {
        return $this->getYoutubeIdFromUrl($media->getName());
    }

    public function getPublicUrl(Media $media)
    {
        return sprintf('http://www.youtube.com/embed/%s', $this->generateReferenceName($media));
    }

    public function isTransformable(Media $media)
    {
        return true;
    }

    public function remove(Media $media)
    {
        return true;
    }

    public function getMetadata(Media $media)
    {
        $metas = array();
        $xml = simplexml_load_file(sprintf(
            self::FEEDS_API_VIDEO_URL_FORMAT,
            $media->getProviderReference()
        ));

        // Retrieve all metadata linked to the access control of the video
        foreach ($xml->xpath('//yt:accessControl') as $node) {
            $metas[$node['action']->__toString()] = $node['permission']->__toString();
        }

        // Retrieve all metadata linked to the properties of the video
        foreach ($xml->xpath('//yt:uploaded') as $node) {
            $metas['uploaded'] = $node[0]->__toString();
        }
        foreach ($xml->xpath('//yt:aspectRatio') as $node) {
            $metas['aspectRatio'] = $node[0]->__toString();
        }
        foreach ($xml->xpath('//yt:duration/@seconds') as $node) {
            $metas['duration'] = $node[0]->__toString();
        }

        return $metas;
    }

    public function getAuthor(Media $media)
    {
        $xml = simplexml_load_file(sprintf(
            self::FEEDS_API_VIDEO_URL_FORMAT,
            $media->getProviderReference()
        ));

        return $xml->author->name->__toString();
    }

    public function getDescription(Media $media)
    {
        $xml = simplexml_load_file(sprintf(
            self::FEEDS_API_VIDEO_URL_FORMAT,
            $media->getProviderReference()
        ));

        $description = '';
        foreach ($xml->xpath('//media:description') as $node) {
            $description = $node[0]->__toString();
        }

        return $description;
    }

    /**
     * Get youtube video ID from URL.
     *
     * @param string $url
     *
     * @return string youtube video id or FALSE if none found
     */
    public function getYoutubeIdFromUrl($url)
    {
        $pattern =
            '%^             # Match any youtube URL
            (?:https?://)?  # Optional scheme. Either http or https
            (?:www\.)?      # Optional www subdomain
            (?:             # Group host alternatives
              youtu\.be/    # Either youtu.be,
            | youtube\.com  # or youtube.com
              (?:           # Group path alternatives
                /embed/     # Either /embed/
              | /v/         # or /v/
              | /watch\?v=  # or /watch\?v=
              )             # End path alternatives.
            )               # End host alternatives.
            ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
            $%x'
         ;
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }

        return false;
    }
}
