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
 * @ORM\Entity(repositoryClass="IDCI\Bundle\SimpleMediaBundle\Repository\TagRepository")
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
     * @ORM\ManyToMany(targetEntity="IDCI\Bundle\SimpleMediaBundle\Entity\OwnerMedia", mappedBy="tags")
     */
    private $ownerMedias;

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
     * @return Tag
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
        $this->ownerMedias = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add mediaOwnerMedias
     *
     * @param \IDCI\Bundle\SimpleMediaBundle\Entity\OwnerMedia $ownerMedias
     * @return MediaTag
     */
    public function addOwnerMedia(\IDCI\Bundle\SimpleMediaBundle\Entity\ownerMedia $ownerMedias)
    {
        $this->ownerMedias[] = $ownerMedias;
    
        return $this;
    }

    /**
     * Remove ownerMedias
     *
     * @param \IDCI\Bundle\SimpleMediaBundle\Entity\ownerMedia $ownerMedias
     */
    public function removeOwnerMedia(\IDCI\Bundle\SimpleMediaBundle\Entity\ownerMedia $ownerMedias)
    {
        $this->ownerMedias->removeElement($ownerMedias);
    }

    /**
     * Get mediaOwnerMedias
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOwnerMedias()
    {
        return $this->ownerMedias;
    }
}
