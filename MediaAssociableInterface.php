<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */

namespace IDCI\Bundle\SimpleMediaBundle;

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
