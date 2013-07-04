<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 *
 */

namespace IDCI\Bundle\SimpleMediaBundle\Provider;

/**
 * ProviderFactory
 */
abstract class ProviderFactory
{
    static $CLASS_PROVIDER_FILE = 'FileProvider';
    static $CLASS_PROVIDER_YOUTUBE = 'YoutubeProvider';

    public static function getNameClassMap()
    {
        return array(
            'file'    => self::$CLASS_PROVIDER_FILE,
            'youtube' => self::$CLASS_PROVIDER_YOUTUBE,
        );
    }

    public static function getClassName($name)
    {
        $map = self::getNameClassMap();

        return $map[$name];
    }

    public static function getInstance($name)
    {
        $className = sprintf(
            'IDCI\Bundle\SimpleMediaBundle\Provider\%s',
            self::getClassName($name)
        );

        return new $className();
    }
}
