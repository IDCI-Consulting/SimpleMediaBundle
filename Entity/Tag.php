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
class Tag
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
     * @ORM\Column(name="name", unique=true, type="string", length=64)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="IDCI\Bundle\SimpleMediaBundle\Entity\AssociatedMedia", mappedBy="tags")
     */
    private $associatedMedias;

    /**
     * toString
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Constructor
     */
    public function __construct($tagName = null)
    {
        $this->associatedMedias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setName($tagName);
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
     * Set name
     *
     * @param string $name
     * @return Tag
     */
    public function setName($name)
    {
        $this->name = trim($name);
    
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
     * Add associatedMedias
     *
     * @param \IDCI\Bundle\SimpleMediaBundle\Entity\AssociatedMedia $associatedMedias
     * @return Tag
     */
    public function addAssociatedMedia(\IDCI\Bundle\SimpleMediaBundle\Entity\AssociatedMedia $associatedMedias)
    {
        $this->associatedMedias[] = $associatedMedias;
    
        return $this;
    }

    /**
     * Remove associatedMedias
     *
     * @param \IDCI\Bundle\SimpleMediaBundle\Entity\AssociatedMedia $associatedMedias
     */
    public function removeAssociatedMedia(\IDCI\Bundle\SimpleMediaBundle\Entity\AssociatedMedia $associatedMedias)
    {
        $this->associatedMedias->removeElement($associatedMedias);
    }

    /**
     * Get associatedMedias
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAssociatedMedias()
    {
        return $this->associatedMedias;
    }
}