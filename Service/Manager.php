<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */

namespace IDCI\Bundle\SimpleMediaBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use IDCI\Bundle\SimpleMediaBundle\Entity\MediaAssociableInterface;
use IDCI\Bundle\SimpleMediaBundle\Entity\Media;
use IDCI\Bundle\SimpleMediaBundle\Entity\AssociatedMedia;
use IDCI\Bundle\SimpleMediaBundle\Entity\Tag;
use IDCI\Bundle\SimpleMediaBundle\Form\Type\AssociatedMediaType;
use IDCI\Bundle\SimpleMediaBundle\Form\Type\FileMediaType;
use IDCI\Bundle\SimpleMediaBundle\Provider\ProviderFactory;

class Manager
{
    protected $em;
    protected $formFactory;

    public function __construct(EntityManager $em, FormFactory $form_factory)
    {
        $this->em = $em;
        $this->formFactory = $form_factory;
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
     * Get Hash for a given object which mush implement MediaAssociableInterface
     *
     * @param MediaAssociableInterface $media_associable
     * @return string The generated hash
     */
    public function getHash(MediaAssociableInterface $media_associable)
    {
        $reflection = new \ReflectionClass($media_associable);

        if(self::isProxyClass($reflection) && $reflection->getParentClass()) {
            $reflection = $reflection->getParentClass();
        }

        $raw = sprintf('%s_%s',
            $reflection->getName(),
            $media_associable->getId()
        );

        return md5($raw);
    }


    /**
     * Add media attach a media to a given MediaAssociableInterface object
     *
     * @param MediaAssociableInterface $media_associable
     * @param Media $media
     * @param array $tags
     * @return void
     */
    public function addMedia(MediaAssociableInterface $media_associable, Media $media, $tags = array())
    {
        $associatedMedia = new AssociatedMedia();
        $hash = $this->getHash($media_associable);
        $associatedMedia->setHash($hash);
        $associatedMedia->setMedia($media);

        foreach($tags as $t) {
            $tagName = $t;
            if($t instanceof IDCI\Bundle\SimpleMediaBundle\Entity\Tag) {
              $tagName = $tag->getName();
            }

            $tag = $this->getEntityManager()
                ->getRepository('IDCISimpleMediaBundle:Tag')
                ->findOneBy(array('name' => $tagName))
            ;
            if(!$t instanceof IDCI\Bundle\SimpleMediaBundle\Entity\Tag && !$tag) {
                $tag = new Tag($tagName);
            }
            $associatedMedia->addTag($tag);
        }

        $this->getEntityManager()->persist($associatedMedia);
        $this->getEntityManager()->flush();
    }

    /**
     * Get medias associated to a given MediaAssociableInterface object and or Tags
     *
     * @param MediaAssociableInterface $media_associable
     * @param array $tagNames
     * @return DoctrineCollection
     */
    public function getMedias(MediaAssociableInterface $media_associable = null, $tagNames = array())
    {
        if(null !== $media_associable) {
            return $this->getEntityManager()
                ->getRepository('IDCISimpleMediaBundle:Media')
                ->findMediasByHashAndTags($this->getHash($media_associable), $tagNames)
            ;
        } else {
            return $this->getEntityManager()
                ->getRepository('IDCISimpleMediaBundle:Media')
                ->findMediasByTags($tagNames)
            ;
        }
    }

    /**
     * create a form based on the given on and attach media input fields
     *
     * @param FormType $form
     * @param array $options
     * @return FormType
     */
    public function createForm($type, MediaAssociableInterface &$media_associable, array $options = array('provider' => 'file'))
    {
        return $this->getFormFactory()->create(
            new AssociatedMediaType(),
            new AssociatedMedia(),
            array(
                'mediaAssociableType' => $type,
                'mediaAssociable'     => $media_associable,
                'provider'            => ProviderFactory::getInstance($options['provider']),
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
        $associatedMedia = $form->getData();
        $mediaAssociable = $form->get('mediaAssociable')->getData();
        $media = $form->get('media')->getData();
        $providerName = $form->get('provider')->getData();
        $provider = ProviderFactory::getInstance($providerName);
        $provider->transform($media);

        $this->getEntityManager()->persist($mediaAssociable);
        $this->getEntityManager()->flush();

        $this->addMedia($mediaAssociable, $media, $associatedMedia->getTags());

        return $mediaAssociable;
    }
}
