<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 *
 */

namespace IDCI\Bundle\SimpleMediaBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use IDCI\Bundle\SimpleMediaBundle\Entity\MediaAssociableInterface;
use IDCI\Bundle\SimpleMediaBundle\Entity\Media;
use IDCI\Bundle\SimpleMediaBundle\Entity\AssociatedMedia;
use IDCI\Bundle\SimpleMediaBundle\Entity\Tag;
use IDCI\Bundle\SimpleMediaBundle\Form\Type\MediaAssociableType;
use IDCI\Bundle\SimpleMediaBundle\Form\Type\FileMediaType;
use IDCI\Bundle\SimpleMediaBundle\Provider\ProviderFactory;

class Manager
{
    protected $em;
    protected $formFactory;

    public function __construct(EntityManager $em, FormFactory $formFactory)
    {
        $this->em = $em;
        $this->formFactory = $formFactory;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->em;
    }

    /**
     * @return FormFactory
     */
    public function getFormFactory()
    {
        return $this->formFactory;
    }

    /**
     * Is a proxy class
     *
     * @param ReflectionClass $reflection
     * @return boolean
     */
    public static function isProxyClass(\ReflectionClass $reflection)
    {
        return in_array('Doctrine\ORM\Proxy\Proxy', array_keys($reflection->getInterfaces()));
    }

    /**
     * Retrieve the classname for a given MediaAssociableInterface
     *
     * @param MediaAssociableInterface $mediaAssociable
     * @return string
     */
    public function getClassName(MediaAssociableInterface $mediaAssociable)
    {
        $reflection = new \ReflectionClass($mediaAssociable);

        if(self::isProxyClass($reflection) && $reflection->getParentClass()) {
            $reflection = $reflection->getParentClass();
        }

        return $reflection->getName();
    }

    /**
     * Get Hash for a given object which mush implement MediaAssociableInterface
     *
     * @param MediaAssociableInterface $mediaAssociable
     * @return string The generated hash
     */
    public function getHash(MediaAssociableInterface $mediaAssociable)
    {
        $raw = sprintf('%s_%s',
            $this->getClassName($mediaAssociable),
            $mediaAssociable->getId()
        );

        return md5($raw);
    }

    /**
     * Add media attach a media to a given MediaAssociableInterface object
     *
     * @param MediaAssociableInterface $mediaAssociable
     * @param Media $media
     * @param array $tags
     * @return void
     */
    public function addMedia(MediaAssociableInterface $mediaAssociable, Media $media, $tags = array())
    {
        $hash = $this->getHash($mediaAssociable);
        $className = $this->getClassName($mediaAssociable);

        $associatedMedia = new AssociatedMedia();
        $associatedMedia->setHash($hash);
        $associatedMedia->setMediaAssociableClassName($className);
        $associatedMedia->setMediaAssociableId($mediaAssociable->getId());
        $associatedMedia->setMedia($media);

        foreach($tags as $tag) {
            $associatedMedia->addTag($this->cleanTag($tag));
        }

        $this->getEntityManager()->persist($associatedMedia);
        $this->getEntityManager()->flush();
    }

    /**
     * Clean tag
     *
     * @param Tag|string $tag
     * @return Tag
     */
    public function cleanTag($tag)
    {
        if($tag instanceof Tag) {
            if($t = $this->tagExist($tag->getName())) {
                return $t;
            }

            return $tag;
        }

        if($t = $this->tagExist($tag)) {
            return $t;
        }

        return new Tag($tag);
    }

    /**
     * Load tags
     *
     * @param string $tagNames
     * @return array
     */
    public function loadTags($tagNames)
    {
        $tags = array();
        foreach($tagNames as $tagName) {
            $tag[] = $this->cleanTag($tagName);
        }

        return $tags;
    }

    /**
     * Tag exist
     *
     * @param string $tagName
     * @return Tag|false
     */
    public function tagExist($tagName)
    {
        $tag = $this->getEntityManager()
            ->getRepository('IDCISimpleMediaBundle:Tag')
            ->findOneBy(array('name' => $tagName))
        ;

        return $tag ? $tag : false;
    }

    /**
     * Retrieve Tags (all or associated to a MediaAssociableInterface if given)
     *
     * @param MediaAssociableInterface|null $mediaAssociable
     * @return DoctrineCollection
     */
    public function getTags(MediaAssociableInterface $mediaAssociable = null)
    {
        if(null !== $mediaAssociable) {
            return $this->getEntityManager()
                ->getRepository('IDCISimpleMediaBundle:Tag')
                ->findTagsForMedia($this->getHash($mediaAssociable))
            ;
        } else {
            return $this->getEntityManager()
                ->getRepository('IDCISimpleMediaBundle:Tag')
                ->findAll()
            ;
        }
    }

    /**
     * Get medias associated to a given MediaAssociableInterface object and or Tags
     *
     * @param MediaAssociableInterface|null $mediaAssociable
     * @param array $tagNames
     * @return DoctrineCollection
     */
    public function getMedias(MediaAssociableInterface $mediaAssociable = null, $tagNames = array())
    {
        if(null !== $mediaAssociable) {
            return $this->getEntityManager()
                ->getRepository('IDCISimpleMediaBundle:Media')
                ->findMediasByHashAndTags($this->getHash($mediaAssociable), $tagNames, true)
            ;
        } else {
            return $this->getEntityManager()
                ->getRepository('IDCISimpleMediaBundle:Media')
                ->findMediasByTags($tagNames, true)
            ;
        }
    }

    /**
     * remove Associated Medias
     *
     * @param MediaAssociableInterface $mediaAssociable
     * @return void
     */
    public function removeAssociatedMedias(MediaAssociableInterface $mediaAssociable)
    {
        $associatedMedias = $this->getEntityManager()
            ->getRepository('IDCISimpleMediaBundle:AssociatedMedia')
            ->findBy(array('hash' => $this->getHash($mediaAssociable)))
        ;

        foreach($associatedMedias as $associatedMedia) {
            $this->removeMedia($associatedMedia->getMedia());
        }
    }

    /**
     * remove Media
     *
     * @param Media $media
     * @return void
     */
    public function removeMedia(Media $media)
    {
        $this->getEntityManager()->remove($media);
    }

    /**
     * create a form based on a given Type/MediaAssociableInterface and attach media input fields
     *
     * @param FormType $form
     * @param array $options
     * @return FormType
     */
    public function createForm($type, MediaAssociableInterface &$mediaAssociable, array $options = array('provider' => 'file'))
    {
        return $this->getFormFactory()->create(
            new MediaAssociableType(),
            null,
            array(
                'mediaAssociableType' => $type,
                'mediaAssociable'     => $mediaAssociable,
                'provider'            => ProviderFactory::getInstance($options['provider']),
                'hash'                => $this->getHash($mediaAssociable),
                'em'                  => $this->getEntityManager(),
            )
        );
    }

    /**
     * process a form
     *
     * @param Form $form
     * @return void
     */
    public function processForm($form)
    {
        $mediaAssociable = $form->get('mediaAssociable')->getData();
        $associatedMedia = $form->get('associatedMedia')->getData();
        $media = $associatedMedia->getMedia();

        $this->getEntityManager()->persist($mediaAssociable);
        $this->getEntityManager()->flush();

        if($media->isTransformable()) {
            $this->addMedia($mediaAssociable, $media, $associatedMedia->getTags());
        }

        return $mediaAssociable;
    }
}
