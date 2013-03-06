<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */

namespace IDCI\Bundle\SimpleMediaBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use IDCI\Bundle\SimpleMediaBundle\Entity\Tag;

class TagsToTextTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct($manager)
    {
        $this->manager = $manager;
    }

    public function getManager()
    {
        return $this->manager;
    }

    /**
     * Transforms tags to a string.
     *
     * @param array|null $tags
     * @return string
     */
    public function transform($tags)
    {
        if (!$tags) {
            $tags = array();
        }
        
        $tagNames = array();
        foreach ($tags as $tag) {
            array_push($tagNames, $tag->getName());
        }

        return implode(', ', $tagNames);
    }

    /**
     * Transforms a string to an array of tags.
     *
     * @param  string $tagNames
     * @return array
     */
    public function reverseTransform($tagNames)
    {
        if (!$tagNames) {
            $tagNames = '';
        }

        // 1. Split the string with commas
        // 2. Remove whitespaces around the tags
        // 3. Remove empty elements (like in "tag1,tag2, ,,tag3,tag4")
        $cleanTagNames = array_filter(array_map('trim', explode(',', $tagNames)));

        return $this->getManager()->loadTags($cleanTagNames);
    }
}