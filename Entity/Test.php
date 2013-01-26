<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @licence: GPL
 *
 */

namespace IDCI\Bundle\SimpleMediaBundle\Entity;

use IDCI\Bundle\SimpleMediaBundle\MediaAssociableInterface;

/**
 * Test
 *
 */
class Test implements MediaAssociableInterface
{
    protected $name;

    public function __construct()
    {
        $name = 'Hello world';
    }

    public function getId()
    {
        return 21;
    }
}
