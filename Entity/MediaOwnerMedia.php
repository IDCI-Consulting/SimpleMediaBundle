<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */

namespace IDCI\Bundle\SimpleMediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MediaOwnerMedia
 *
 * @ORM\Table(name="idci_media_owner_media")
 * @ORM\Entity(repositoryClass="IDCI\Bundle\SimpleMediaBundle\Repository\MediaOwnerMediaRepository")
 */
class MediaOwnerMedia
{
    /**
     * @ORM\ManyToOne(targetEntity="IDCI\Bundle\SimpleMediaBundle\Entity\Media", inversedBy="mediaOwnerMedias")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id")
     */
    private $media;
    
    /**
     * @ORM\ManyToOne(targetEntity="IDCI\Bundle\SimpleMediaBundle\Entity\MediaOwner", inversedBy="mediaOwnerMedias")
     * @ORM\JoinColumn(name="media_owner_id", referencedColumnName="id")
     */
    private $media_owner; 
    
    /**
     * madia tags
     *
     * @ORM\ManyToMany(targetEntity="IDCI\Bundle\SimpleMediaBundle\Entity\MediaTag", inversedBy="mediaOwnerMedias", cascade={"persist"})
     * @ORM\JoinTable(name="idci_media_media_tags_media_owner_media",
     *     joinColumns={@ORM\JoinColumn(name="media_owner_media_id", referencedColumnName="id", onDelete="Cascade")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="media_tag_id", referencedColumnName="id", onDelete="Cascade")}
     * )
     */
     protected $media_tags;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->media_tags = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set media
     *
     * @param \IDCI\Bundle\SimpleMediaBundle\Entity\Media $media
     * @return MediaOwnerMedia
     */
    public function setMedia(\IDCI\Bundle\SimpleMediaBundle\Entity\Media $media = null)
    {
        $this->media = $media;
    
        return $this;
    }

    /**
     * Get media
     *
     * @return \IDCI\Bundle\SimpleMediaBundle\Entity\Media 
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Set media_owner
     *
     * @param \IDCI\Bundle\SimpleMediaBundle\Entity\MediaOwner $mediaOwner
     * @return MediaOwnerMedia
     */
    public function setMediaOwner(\IDCI\Bundle\SimpleMediaBundle\Entity\MediaOwner $mediaOwner = null)
    {
        $this->media_owner = $mediaOwner;
    
        return $this;
    }

    /**
     * Get media_owner
     *
     * @return \IDCI\Bundle\SimpleMediaBundle\Entity\MediaOwner 
     */
    public function getMediaOwner()
    {
        return $this->media_owner;
    }

    /**
     * Add media_tags
     *
     * @param \IDCI\Bundle\SimpleMediaBundle\Entity\MediaTag $mediaTags
     * @return MediaOwnerMedia
     */
    public function addMediaTag(\IDCI\Bundle\SimpleMediaBundle\Entity\MediaTag $mediaTags)
    {
        $this->media_tags[] = $mediaTags;
    
        return $this;
    }

    /**
     * Remove media_tags
     *
     * @param \IDCI\Bundle\SimpleMediaBundle\Entity\MediaTag $mediaTags
     */
    public function removeMediaTag(\IDCI\Bundle\SimpleMediaBundle\Entity\MediaTag $mediaTags)
    {
        $this->media_tags->removeElement($mediaTags);
    }

    /**
     * Get media_tags
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMediaTags()
    {
        return $this->media_tags;
    }
}