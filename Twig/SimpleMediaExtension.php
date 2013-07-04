<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 *
 */

namespace IDCI\Bundle\SimpleMediaBundle\Twig;

class SimpleMediaExtension extends \Twig_Extension
{
    protected $mediaManager;

    public function __construct($media_manager)
    {
        $this->mediaManager = $media_manager;
    }

    public function getMediaManager()
    {
        return $this->mediaManager;
    }

    public function getName()
    {
        return 'simple_media';
    }

    public function getFunctions()
    {
        return array(
            'medias'      => new \Twig_Function_Method($this, 'get_medias'),
            'medias_tags' => new \Twig_Function_Method($this, 'get_tags'),
        );
    }

    public function get_medias($media_associable = null, $tags = array())
    {
        return $this->getMediaManager()->getMedias($media_associable, $tags);
    }

    public function get_tags($media_associable = null)
    {
        return $this->getMediaManager()->getTags($media_associable);
    }
}
