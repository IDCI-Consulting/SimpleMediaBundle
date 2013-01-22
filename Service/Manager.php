<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */

use IDCI\Bundle\SimpleMediaBundle\Entity\Media;
use IDCI\Bundle\SimpleMediaBundle\Entity\MediaOwnerMedia;
use Doctrine\ORM\EntityManager;

namespace IDCI\Bundle\SimpleMediaBundle\Service;

class Manager
{
    protected $em;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function addMedia($hash, Media $media, array $tags = array())
    {
        $mom = new MediaOwnerMedia();
        $mom->setMedia($media);
        $mom->setHash($hash);
        $mom->setTags($tags);
        
        $this->em->persist($mom);
        $this->em->flush();
    }
    
    public function getMedias($hash)
    {
        return $this->em->getRepository('IDCISimpleMediaBundle:MediaOwnerMedia')->findMediasByHash($hash);
    }
}
