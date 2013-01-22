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
}