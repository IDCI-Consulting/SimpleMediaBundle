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
 * @ORM\Table(name="idci_owner_media")
 * @ORM\Entity(repositoryClass="IDCI\Bundle\SimpleMediaBundle\Repository\OwnerMediaRepository")
 */
class MediaOwnerMedia
{
    /**
     * @ORM\ManyToOne(targetEntity="IDCI\Bundle\SimpleMediaBundle\Entity\Media", inversedBy="ownerMedias")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id")
     */
    private $media;
    
    /**
     * @ORM\ManyToOne(targetEntity="IDCI\Bundle\SimpleMediaBundle\Entity\Owner", inversedBy="ownerMedias")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    private $owner;
    
    /**
     * madia tags
     *
     * @ORM\ManyToMany(targetEntity="IDCI\Bundle\SimpleMediaBundle\Entity\Tag", inversedBy="ownerMedias", cascade={"persist"})
     * @ORM\JoinTable(name="idci_tags_owner",
     *     joinColumns={@ORM\JoinColumn(name="owner_media_id", referencedColumnName="id", onDelete="Cascade")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id", onDelete="Cascade")}
     * )
     */
     protected $tags;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set owner
     *
     * @param \IDCI\Bundle\SimpleMediaBundle\Entity\MediaOwner $owner
     * @return OwnerMedia
     */
    public function setOwner(\IDCI\Bundle\SimpleMediaBundle\Entity\MediaOwner $owner = null)
    {
        $this->owner = $owner;
    
        return $this;
    }

    /**
     * Get owner
     *
     * @return \IDCI\Bundle\SimpleMediaBundle\Entity\Owner 
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Add tags
     *
     * @param \IDCI\Bundle\SimpleMediaBundle\Entity\Tag $tags
     * @return OwnerMedia
     */
    public function addTag(\IDCI\Bundle\SimpleMediaBundle\Entity\Tag $tags)
    {
        $this->tags[] = $tags;
    
        return $this;
    }

    /**
     * Remove tags
     *
     * @param \IDCI\Bundle\SimpleMediaBundle\Entity\Tag $tags
     */
    public function removeTag(\IDCI\Bundle\SimpleMediaBundle\Entity\Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }
}
