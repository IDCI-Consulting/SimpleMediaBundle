<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */

namespace IDCI\Bundle\SimpleMediaBundle\Repository;

use Doctrine\ORM\EntityRepository;

class MediaRepository extends EntityRepository
{
    /**
     * Find medias for a given hash 
     * 
     * @return entities
     */
    public function findMediasByHash($hash)
    {
        $q = $this->findMediasByHashQuery($hash);

        return is_null($q) ? array() : $q->getResult();
    }
    
    /**
     * Find medias for a given hash based on a query
     *
     * @return DoctrineQuery
     */
    public function findMediasByHashQuery($hash)
    {
        $qb = $this->findMediasByHashQueryBuilder($hash);

        return is_null($qb) ? $qb : $qb->getQuery();
    }

    /**
     * Find medias for a given hash based on a query builder
     *
     * @return DoctrineQueryBuilder
     */
    public function findMediasByHashQueryBuilder($hash)
    {
        $qb = $this->createQueryBuilder('m');

        $qb
            ->leftJoin('m.associatedMedias', 'am')
            ->where('am.hash = :hash')
            ->setParameter('hash', $hash)
        ;

        return $qb;
    }

    /**
     * Find medias for a given hash filter by tag's names
     * 
     * @return entities
     */
    public function findMediasByHashAndTags($hash, $tagNames)
    {
        $q = $this->findMediasByHashAndTagsQuery($hash, $tagNames);

        return is_null($q) ? array() : $q->getResult();
    }
    
    /**
     * Find medias for a given hash filter by tag's names based on a query
     *
     * @return DoctrineQuery
     */
    public function findMediasByHashAndTagsQuery($hash, $tagNames)
    {
        $qb = $this->findMediasByHashAndTagsQueryBuilder($hash, $tagNames);

        return is_null($qb) ? $qb : $qb->getQuery();
    }

    /**
     * Find medias for a given hash filter by tag's names based on a query builder
     *
     * @return DoctrineQueryBuilder
     */
    public function findMediasByHashAndTagsQueryBuilder($hash, $tagNames)
    {
        $qb = $this->findMediasByHashQueryBuilder($hash);

        if(isset($tagNames[0])) {
            $qb
                ->leftJoin('am.tags', 't')
                ->andWhere($qb->expr()->in('t.name', $tagNames))
            ;
        }

        return $qb;
    }

    /**
     * Find medias by tag's names
     * 
     * @return entities
     */
    public function findMediasByTags($tagNames)
    {
        $q = $this->findMediasByTagsQuery($tagNames);

        return is_null($q) ? array() : $q->getResult();
    }
    
    /**
     * Find medias filter by tag's names based on a query
     *
     * @return DoctrineQuery
     */
    public function findMediasByTagsQuery($tagNames)
    {
        $qb = $this->findMediasByTagsQueryBuilder($tagNames);

        return is_null($qb) ? $qb : $qb->getQuery();
    }

    /**
     * Find medias filter by tag's names based on a query builder
     *
     * @return DoctrineQueryBuilder
     */
    public function findMediasByTagsQueryBuilder($tagNames)
    {
        $qb = $this->createQueryBuilder('m');

        $qb
            ->leftJoin('m.associatedMedias', 'am')
            ->leftJoin('am.tags', 't')
            ->andWhere($qb->expr()->in('t.name', $tagNames))
        ;

        return $qb;
    }
}
