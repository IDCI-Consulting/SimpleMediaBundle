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
        $q = $this->findfindMediasByHashQuery();

        return is_null($q) ? array() : $q->getResult();
    }
    
    /**
     * Find medias for a given hash  based on a query
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
        $qb = $this->createQueryBuilder("m");

        $qb
            ->where("m.hash = :hash")
            ->setParameter("hash", $hash)
        ;

        return $qb;
    }
}
