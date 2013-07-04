<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 *
 */

namespace IDCI\Bundle\SimpleMediaBundle\Entity;

/**
 * MediaAssociableInterface
 */
interface MediaAssociableInterface
{
    /**
     * Get id must return a unique identifier.
     *
     * @return string | int
     */
    public function getId();
}
