<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 *
 */

namespace IDCI\Bundle\SimpleMediaBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use IDCI\Bundle\SimpleMediaBundle\Entity\Tag;

class TagsToListTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    /**
     * Transforms an object collection (tags) to a string (list).
     *
     * @param array|null $tags
     * @return string
     */
    public function transform($tags)
    {
        if (null === $tags) {
            return "";
        }

        $list = array();
        foreach($tags as $tag) {
            $list[] = $tag->getName();
        }

        return implode(",", $list);
    }

    /**
     * Transforms a string (list) to an object collection (tags).
     *
     * @param  string $list
     * @return array|null
     */
    public function reverseTransform($list)
    {
        if (!$list) {
            return array();
        }

        $tags = array();
        foreach(explode(",", $list) as $item) {
            $tagName = trim($item);
            $tag = $this->om
                ->getRepository('IDCISimpleMediaBundle:Tag')
                ->findOneBy(array('name' => $tagName))
            ;
            if(!$tag) {
                $tag = new Tag($tagName);
            }
            $tags[] = $tag;
        }

        return $tags;
    }
}
