<?php

namespace IDCI\Bundle\SimpleMediaBundle\Repository;

/*
 *
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 *
 */

use Doctrine\ORM\EntityRepository;

class MediaRepository extends EntityRepository
{
    /**
     * Find medias for a given hash.
     *
     * @param string    $hash
     * @param bool|null $enableStatus
     *
     * @return DoctrineCollection
     */
    public function findMediasByHash($hash, $enableStatus = null)
    {
        $q = $this->findMediasByHashQuery($hash, $enableStatus);

        return is_null($q) ? array() : $q->getResult();
    }

    /**
     * Find medias for a given hash based on a query.
     *
     * @param string    $hash
     * @param bool|null $enableStatus
     *
     * @return DoctrineQuery
     */
    public function findMediasByHashQuery($hash, $enableStatus = null)
    {
        $qb = $this->findMediasByHashQueryBuilder($hash, $enableStatus);

        return is_null($qb) ? $qb : $qb->getQuery();
    }

    /**
     * Find medias for a given hash based on a query builder.
     *
     * @param string    $hash
     * @param bool|null $enableStatus
     *
     * @return DoctrineQueryBuilder
     */
    public function findMediasByHashQueryBuilder($hash, $enableStatus = null)
    {
        $qb = $this->createQueryBuilder('m');

        $qb
            ->leftJoin('m.associatedMedias', 'am')
            ->where('am.hash = :hash')
            ->setParameter('hash', $hash)
        ;

        if (!is_null($enableStatus)) {
            $qb
                ->andWhere('m.enabled = :enabled')
                ->setParameter('enabled', $enableStatus)
            ;
        }

        return $qb;
    }

    /**
     * Find medias for a given hash filter by tag's names.
     *
     * @param string    $hash
     * @param array     $tagNames
     * @param bool|null $enableStatus
     *
     * @return DoctrineCollection
     */
    public function findMediasByHashAndTags($hash, $tagNames, $enableStatus = null)
    {
        $q = $this->findMediasByHashAndTagsQuery($hash, $tagNames, $enableStatus);

        return is_null($q) ? array() : $q->getResult();
    }

    /**
     * Find medias for a given hash filter by tag's names based on a query.
     *
     * @param string    $hash
     * @param array     $tagNames
     * @param bool|null $enableStatus
     *
     * @return DoctrineQuery
     */
    public function findMediasByHashAndTagsQuery($hash, $tagNames, $enableStatus = null)
    {
        $qb = $this->findMediasByHashAndTagsQueryBuilder($hash, $tagNames, $enableStatus);

        return is_null($qb) ? $qb : $qb->getQuery();
    }

    /**
     * Find medias for a given hash filter by tag's names based on a query builder.
     *
     * @param string    $hash
     * @param array     $tagNames
     * @param bool|null $enableStatus
     *
     * @return DoctrineQueryBuilder
     */
    public function findMediasByHashAndTagsQueryBuilder($hash, $tagNames, $enableStatus = null)
    {
        $qb = $this->findMediasByHashQueryBuilder($hash, $enableStatus);

        if (isset($tagNames[0])) {
            $qb
                ->leftJoin('am.tags', 't')
                ->andWhere($qb->expr()->in('t.name', $tagNames))
            ;
        }

        return $qb;
    }

    /**
     * Find medias by tag's names.
     *
     * @param array     $tagNames
     * @param bool|null $enableStatus
     *
     * @return DoctrineCollection
     */
    public function findMediasByTags($tagNames, $enableStatus = null)
    {
        $q = $this->findMediasByTagsQuery($tagNames, $enableStatus);

        return is_null($q) ? array() : $q->getResult();
    }

    /**
     * Find medias filter by tag's names based on a query.
     *
     * @param array     $tagNames
     * @param bool|null $enableStatus
     *
     * @return DoctrineQuery
     */
    public function findMediasByTagsQuery($tagNames, $enableStatus = null)
    {
        $qb = $this->findMediasByTagsQueryBuilder($tagNames, $enableStatus);

        return is_null($qb) ? $qb : $qb->getQuery();
    }

    /**
     * Find medias filter by tag's names based on a query builder.
     *
     * @param array     $tagNames
     * @param bool|null $enableStatus
     *
     * @return DoctrineQueryBuilder
     */
    public function findMediasByTagsQueryBuilder($tagNames, $enableStatus = null)
    {
        $qb = $this->createQueryBuilder('m');

        if (!is_null($enableStatus)) {
            $qb
                ->andWhere('m.enabled = :enabled')
                ->setParameter('enabled', $enableStatus)
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
