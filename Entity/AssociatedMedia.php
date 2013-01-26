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
 * AssociatedMedia
 *
 * @ORM\Table(name="idci_media_associated_media", indexes={
 *     @ORM\Index(name="hash_idx", columns={"hash"})
 * }, uniqueConstraints={
 *     @ORM\UniqueConstraint(name="single_media_idx", columns={"hash", "media_id"})
 * })
 * @ORM\Entity(repositoryClass="IDCI\Bundle\SimpleMediaBundle\Repository\AssociatedMediaRepository")
 */
class AssociatedMedia
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="hash", type="string", length=255)
     */
    private $hash;

    /**
     * media
     *
     * @ORM\ManyToOne(targetEntity="IDCI\Bundle\SimpleMediaBundle\Entity\Media", inversedBy="associatedMedias", cascade={"persist"})
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id")
     */
    private $media;

    /**
     * tags
     *
     * @ORM\ManyToMany(targetEntity="IDCI\Bundle\SimpleMediaBundle\Entity\Tag", inversedBy="associatedMedias", cascade={"persist"})
     * @ORM\JoinTable(name="idci_media_associated_media_tag",
     *     joinColumns={@ORM\JoinColumn(name="associated_media_id", referencedColumnName="id", onDelete="Cascade")},
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set hash
     *
     * @param string $hash
     * @return AssociatedMedia
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    
        return $this;
    }

    /**
     * Get hash
     *
     * @return string 
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Set media
     *
     * @param \IDCI\Bundle\SimpleMediaBundle\Entity\Media $media
     * @return AssociatedMedia
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
     * Add tags
     *
     * @param \IDCI\Bundle\SimpleMediaBundle\Entity\Tag $tags
     * @return AssociatedMedia
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
