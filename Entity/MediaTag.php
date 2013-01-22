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
 * Media
 *
 * @ORM\Table(name="idci_media_tag")
 * @ORM\Entity(repositoryClass="IDCI\Bundle\SimpleMediaBundle\Repository\MediaTagRepository")
 */
class MediaTag
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    /**
     * @ORM\ManyToMany(targetEntity="IDCI\Bundle\SimpleMediaBundle\Entity\MediaOwnerMedia", mappedBy="tags")
     */
    private $mediaOwnerMedias;

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
     * Set name
     *
     * @param string $name
     * @return MediaTag
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->mediaOwnerMedias = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add mediaOwnerMedias
     *
     * @param \IDCI\Bundle\SimpleMediaBundle\Entity\MediaOwnerMedia $mediaOwnerMedias
     * @return MediaTag
     */
    public function addMediaOwnerMedia(\IDCI\Bundle\SimpleMediaBundle\Entity\MediaOwnerMedia $mediaOwnerMedias)
    {
        $this->mediaOwnerMedias[] = $mediaOwnerMedias;
    
        return $this;
    }

    /**
     * Remove mediaOwnerMedias
     *
     * @param \IDCI\Bundle\SimpleMediaBundle\Entity\MediaOwnerMedia $mediaOwnerMedias
     */
    public function removeMediaOwnerMedia(\IDCI\Bundle\SimpleMediaBundle\Entity\MediaOwnerMedia $mediaOwnerMedias)
    {
        $this->mediaOwnerMedias->removeElement($mediaOwnerMedias);
    }

    /**
     * Get mediaOwnerMedias
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMediaOwnerMedias()
    {
        return $this->mediaOwnerMedias;
    }
}