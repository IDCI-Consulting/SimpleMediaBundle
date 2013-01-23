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
 * @ORM\Entity(repositoryClass="IDCI\Bundle\SimpleMediaBundle\Repository\OwnerRepository")
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
     * @ORM\OneToMany(targetEntity="IDCI\Bundle\SimpleMediaBundle\Entity\OwnerMedia", mappedBy="owner")
     */
    protected $ownerMedias;

    /**
     * Set hash
     *
     * @param string $hash
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
        $this->ownerMedias = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add OwnerMedias
     *
     * @param \IDCI\Bundle\SimpleMediaBundle\Entity\OwnerMedia $ownerMedia
     * @return Owner
     */
    public function addOwnerMedia(\IDCI\Bundle\SimpleMediaBundle\Entity\OwnerMedia $ownerMedia)
    {
        $this->ownerMedias[] = $ownerMedia;
    
        return $this;
    }

    /**
     * Remove OwnerMedias
     *
     * @param \IDCI\Bundle\SimpleMediaBundle\Entity\OwnerMedia $ownerMedia
     */
    public function removeOwnerMedia(\IDCI\Bundle\SimpleMediaBundle\Entity\OwnerMedias $ownerMedia)
    {
        $this->ownerMedias->removeElement($ownerMedia);
    }

    /**
     * Get OwnerMedias
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOwnerMedias()
    {
        return $this->ownerMedias;
    }
}
