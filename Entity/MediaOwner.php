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
 * @ORM\Table(name="idci_media_owner")
 * @ORM\Entity(repositoryClass="IDCI\Bundle\SimpleMediaBundle\Repository\MediaOwnerRepository")
 */
class MediaOwner
{
    /**
     * @var string
     * 
     * @ORM\Column(name="hash", type="string", length=255, unique=true)
     */
    private $hash;
    
    /**
     * @ORM\OneToMany(targetEntity="IDCI\Bundle\SimpleMediaBundle\Entity\MediaOwnerMedias", mappedBy="mediaOwner")
     */
    protected $mediaOwnerMedias;

    /**
     * Set hash
     *
     * @param string $hash
     * @return MediaOwner
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
     * Constructor
     */
    public function __construct()
    {
        $this->mediaOwnerMedias = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add mediaOwnerMedias
     *
     * @param \IDCI\Bundle\SimpleMediaBundle\Entity\MediaOwnerMedias $mediaOwnerMedias
     * @return MediaOwner
     */
    public function addMediaOwnerMedia(\IDCI\Bundle\SimpleMediaBundle\Entity\MediaOwnerMedias $mediaOwnerMedias)
    {
        $this->mediaOwnerMedias[] = $mediaOwnerMedias;
    
        return $this;
    }

    /**
     * Remove mediaOwnerMedias
     *
     * @param \IDCI\Bundle\SimpleMediaBundle\Entity\MediaOwnerMedias $mediaOwnerMedias
     */
    public function removeMediaOwnerMedia(\IDCI\Bundle\SimpleMediaBundle\Entity\MediaOwnerMedias $mediaOwnerMedias)
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