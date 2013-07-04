<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 *
 */

namespace IDCI\Bundle\SimpleMediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use IDCI\Bundle\SimpleMediaBundle\Provider\ProviderFactory;

/**
 * Media
 *
 * @ORM\Table(name="idci_media_media")
 * @ORM\Entity(repositoryClass="IDCI\Bundle\SimpleMediaBundle\Repository\MediaRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Media
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
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var boolean
     * 
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

    /**
     * @var string
     *
     * @ORM\Column(name="providerName", type="string")
     */
    private $providerName;

    /**
     * @var string
     *
     * @ORM\Column(name="providerReference", type="string")
     */
    private $providerReference;

    /**
     * @var string
     *
     * @ORM\Column(name="providerMetadata", type="json_array")
     */
    private $providerMetadata;

    /**
     * @var integer
     *
     * @ORM\Column(name="width", type="integer", nullable=true)
     */
    private $width;

    /**
     * @var integer
     *
     * @ORM\Column(name="heigth", type="integer", nullable=true)
     */
    private $height;

    /**
     * @var integer
     *
     * @ORM\Column(name="size", type="integer", nullable=true)
     */
    private $size;

    /**
     * @var string
     *
     * @ORM\Column(name="contentType", type="string", length=255)
     */
    private $contentType;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255, nullable=true)
     */
    private $author;

    /**
     * @var datetime $updated_at
     * 
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updated_at;

    /**
     * @var datetime $created_at
     * 
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity="IDCI\Bundle\SimpleMediaBundle\Entity\AssociatedMedia", mappedBy="media")
     */
    protected $associatedMedias;

    /**
     * @var Symfony\Component\HttpFoundation\File\UploadedFile $binaryContent
     */
    protected $binaryContent;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->associatedMedias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setEnabled(true);
    }

    /**
     * Set binaryContent
     *
     * @param $binaryContent
     * @return Media
     */
    public function setBinaryContent($binaryContent)
    {
        $this->binaryContent = $binaryContent;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getBinaryContent()
    {
        return $this->binaryContent;
    }

    /**
     * Get provider
     *
     * @return ProviderInterface
     */
    public function getProvider()
    {
        return ProviderFactory::getInstance($this->getProviderName());
    }

    /**
     * isTransformable
     *
     * @return boolean
     */
    public function isTransformable()
    {
        return $this->getProvider()->isTransformable($this);
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->getProvider()->getPublicUrl($this);
    }

    /**
     * onCreation
     *
     * @ORM\PrePersist()
     */
    public function onCreation()
    {
        $now = new \DateTime('now');
        $this->setCreatedAt($now);
        $this->setUpdatedAt($now);
        $this->getProvider()->transform($this);
    }

    /**
     * onUpdate
     *
     * @ORM\PreUpdate()
     */
    public function onUpdate()
    {
        $now = new \DateTime('now');
        $this->setUpdatedAt($now);
        $this->getProvider()->transform($this);
    }

    /**
     * onRemove
     *
     * @ORM\PreRemove
     */
    public function onRemove()
    {
        $this->getProvider()->remove($this);
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
     * @return Media
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
     * Set description
     *
     * @param string $description
     * @return Media
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return Media
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set providerName
     *
     * @param string $providerName
     * @return Media
     */
    public function setProviderName($providerName)
    {
        $this->providerName = $providerName;

        return $this;
    }

    /**
     * Get providerName
     *
     * @return string 
     */
    public function getProviderName()
    {
        return $this->providerName;
    }

    /**
     * Set providerReference
     *
     * @param string $providerReference
     * @return Media
     */
    public function setProviderReference($providerReference)
    {
        $this->providerReference = $providerReference;

        return $this;
    }

    /**
     * Get providerReference
     *
     * @return string 
     */
    public function getProviderReference()
    {
        return $this->providerReference;
    }

    /**
     * Set providerMetadata
     *
     * @param string $providerMetadata
     * @return Media
     */
    public function setProviderMetadata($providerMetadata)
    {
        $this->providerMetadata = $providerMetadata;

        return $this;
    }

    /**
     * Get providerMetadata
     *
     * @return string 
     */
    public function getProviderMetadata()
    {
        return $this->providerMetadata;
    }

    /**
     * Set width
     *
     * @param integer $width
     * @return Media
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return integer 
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param integer $height
     * @return Media
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return integer 
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set size
     *
     * @param integer $size
     * @return Media
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer 
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set contentType
     *
     * @param string $contentType
     * @return Media
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;

        return $this;
    }

    /**
     * Get contentType
     *
     * @return string 
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Media
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     * @return Media
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;

        return $this;
    }

    /**
     * Get updated_at
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Media
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Add associatedMedias
     *
     * @param \IDCI\Bundle\SimpleMediaBundle\Entity\AssociatedMedia $associatedMedia
     * @return Media
     */
    public function addAssociatedMedia(\IDCI\Bundle\SimpleMediaBundle\Entity\AssociatedMedia $associatedMedia)
    {
        $this->associatedMedias[] = $associatedMedia;

        return $this;
    }

    /**
     * Remove associatedMedia
     *
     * @param \IDCI\Bundle\SimpleMediaBundle\Entity\AssociatedMedia $associatedMedia
     */
    public function removeAssociatedMedia(\IDCI\Bundle\SimpleMediaBundle\Entity\AssociatedMedia $associatedMedia)
    {
        $this->associatedMedias->removeElement($associatedMedia);
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
