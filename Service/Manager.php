<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */

namespace IDCI\Bundle\SimpleMediaBundle\Service;

use Doctrine\ORM\EntityManager;
use IDCI\Bundle\SimpleMediaBundle\MediaAssociableInterface;
use IDCI\Bundle\SimpleMediaBundle\Entity\Media;
use IDCI\Bundle\SimpleMediaBundle\Entity\AssociatedMedia;
use IDCI\Bundle\SimpleMediaBundle\Entity\Tag;

class Manager
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Is a proxy class
     *
     * @param ReflectionClass $reflection
     * @return boolean
     */
    public static function isProxyClass(\ReflectionClass $reflection)
    {
        return in_array('Doctrine\ORM\Proxy\Proxy', array_keys($reflection->getInterfaces()));
    }

    /**
     * Get Hash for a given object which mush implement MediaAssociableInterface
     *
     * @param MediaAssociableInterface $media_associable
     * @return string The generated hash
     */
    public function getHash(MediaAssociableInterface $media_associable)
    {
        $reflection = new \ReflectionClass($media_associable);

        if(self::isProxyClass($reflection) && $reflection->getParentClass()) {
            $reflection = $reflection->getParentClass();
        }

        $raw = sprintf('%s_%s',
            $reflection->getName(),
            $media_associable->getId()
        );

        return md5($raw);
    }


    /**
     * Add media attach a media to a given MediaAssociableInterface object
     *
     * @param MediaAssociableInterface $media_associable
     * @param Media $media
     * @param array $tags
     */
    public function addMedia(MediaAssociableInterface $media_associable, Media $media, $tagNames = array())
    {
        $associatedMedia = new AssociatedMedia();
        $hash = $this->getHash($media_associable);
        $associatedMedia->setHash($hash);
        $associatedMedia->setMedia($media);

        foreach($tagNames as $tagName) {
            $tag = $this->em->getRepository('IDCISimpleMediaBundle:Tag')->findOneBy(array('name' => $tagName));
            if(!$tag) {
                $tag = new Tag($tagName);
            }
            $associatedMedia->addTag($tag);
        }

        $this->em->persist($associatedMedia);
        $this->em->flush();
    }

    /**
     * Get medias associated to a given MediaAssociableInterface object
     *
     * @param MediaAssociableInterface $media_associable
     * @return DoctrineCollection
     */
    public function getMedias(MediaAssociableInterface $media_associable)
    {
        return $this->em
            ->getRepository('IDCISimpleMediaBundle:Media')
            ->findMediasByHash($this->getHash($media_associable))
        ;
    }
}
