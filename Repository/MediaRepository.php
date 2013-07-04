<?php

namespace IDCI\Bundle\SimpleMediaBundle\Repository;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 *
 */

use Doctrine\ORM\EntityRepository;

class MediaRepository extends EntityRepository
{
    /**
     * Find medias for a given hash 
     * 
     * @param string $hash
     * @param boolean|null $enable_status
     * @return DoctrineCollection
     */
    public function findMediasByHash($hash, $enable_status = null)
    {
        $q = $this->findMediasByHashQuery($hash, $enable_status);

        return is_null($q) ? array() : $q->getResult();
    }
    
    /**
     * Find medias for a given hash based on a query
     * 
     * @param string $hash
     * @param boolean|null $enable_status
     * @return DoctrineQuery
     */
    public function findMediasByHashQuery($hash, $enable_status = null)
    {
        $qb = $this->findMediasByHashQueryBuilder($hash, $enable_status);

        return is_null($qb) ? $qb : $qb->getQuery();
    }

    /**
     * Find medias for a given hash based on a query builder
     * 
     * @param string $hash
     * @param boolean|null $enable_status
     * @return DoctrineQueryBuilder
     */
    public function findMediasByHashQueryBuilder($hash, $enable_status = null)
    {
        $qb = $this->createQueryBuilder('m');

        $qb
            ->leftJoin('m.associatedMedias', 'am')
            ->where('am.hash = :hash')
            ->setParameter('hash', $hash)
        ;

        if(!is_null($enable_status)) {
            $qb
                ->andWhere('m.enabled = :enabled')
                ->setParameter('enabled', $enable_status)
            ;
        }

        return $qb;
    }

    /**
     * Find medias for a given hash filter by tag's names
     *
     * @param string $hash
     * @param array $tagNames
     * @param boolean|null $enable_status 
     * @return DoctrineCollection
     */
    public function findMediasByHashAndTags($hash, $tagNames, $enable_status = null)
    {
        $q = $this->findMediasByHashAndTagsQuery($hash, $tagNames, $enable_status);

        return is_null($q) ? array() : $q->getResult();
    }
    
    /**
     * Find medias for a given hash filter by tag's names based on a query
     *
     * @param string $hash
     * @param array $tagNames
     * @param boolean|null $enable_status 
     * @return DoctrineQuery
     */
    public function findMediasByHashAndTagsQuery($hash, $tagNames, $enable_status = null)
    {
        $qb = $this->findMediasByHashAndTagsQueryBuilder($hash, $tagNames, $enable_status);

        return is_null($qb) ? $qb : $qb->getQuery();
    }

    /**
     * Find medias for a given hash filter by tag's names based on a query builder
     *
     * @param string $hash
     * @param array $tagNames
     * @param boolean|null $enable_status 
     * @return DoctrineQueryBuilder
     */
    public function findMediasByHashAndTagsQueryBuilder($hash, $tagNames, $enable_status = null)
    {
        $qb = $this->findMediasByHashQueryBuilder($hash, $enable_status);

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
     * @param array $tagNames
     * @param boolean|null $enable_status 
     * @return DoctrineCollection
     */
    public function findMediasByTags($tagNames, $enable_status = null)
    {
        $q = $this->findMediasByTagsQuery($tagNames, $enable_status);

        return is_null($q) ? array() : $q->getResult();
    }
    
    /**
     * Find medias filter by tag's names based on a query
     * 
     * @param array $tagNames
     * @param boolean|null $enable_status
     * @return DoctrineQuery
     */
    public function findMediasByTagsQuery($tagNames, $enable_status = null)
    {
        $qb = $this->findMediasByTagsQueryBuilder($tagNames, $enable_status);

        return is_null($qb) ? $qb : $qb->getQuery();
    }

    /**
     * Find medias filter by tag's names based on a query builder
     * 
     * @param array $tagNames
     * @param boolean|null $enable_status
     * @return DoctrineQueryBuilder
     */
    public function findMediasByTagsQueryBuilder($tagNames, $enable_status = null)
    {
        $qb = $this->createQueryBuilder('m');

        if(!is_null($enable_status)) {
            $qb
                ->andWhere('m.enabled = :enabled')
                ->setParameter('enabled', $enable_status)
            ;
        }

        $qb
            ->leftJoin('m.associatedMedias', 'am')
            ->leftJoin('am.tags', 't')
            ->andWhere($qb->expr()->in('t.name', $tagNames))
        ;

        return $qb;
    }
}
