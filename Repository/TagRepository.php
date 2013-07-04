<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 *
 */

namespace IDCI\Bundle\SimpleMediaBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TagRepository extends EntityRepository
{
    /**
     * Find tags for a given media
     * 
     * @param string $hash
     * @return DoctrineCollection
     */
    public function findTagsForMedia($hash)
    {
        $q = $this->findTagsForMediaQuery($hash);

        return is_null($q) ? array() : $q->getResult(); 
    }

    /**
     * Find tags for a given media based on a query
     * 
     * @param string $hash
     * @return DoctrineQuery
     */
    public function findTagsForMediaQuery($hash)
    {
        $qb = $this->findTagsForMediaQueryBuilder($hash);

        return is_null($qb) ? $qb : $qb->getQuery();
    }

    /**
     * Find tags for a given media based on a query builder
     * 
     * @param string $hash
     * @return DoctrineQueryBuilder
     */
    public function findTagsForMediaQueryBuilder($hash)
    {
        $qb = $this->createQueryBuilder('t');
        $qb
            ->leftJoin('t.associatedMedias', 'am')
            ->where('am.hash = :hash')
            ->setParameter('hash', $hash)
        ;

        return $qb;
    }
}
