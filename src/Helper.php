<?php

namespace Intech\Tool;

use Intech\Tool\Concretes\Helper\Debugging;
use Intech\Tool\Concretes\Helper\File;
use JetBrains\PhpStorm\NoReturn;

class Helper
{
    /**
     * Singleton property
     *
     * Uses for keep instantiated helper concretes
     * for prevent re-instantiate
     *
     * @var array
     */
    private static array $instances;

    /**
     * Returns debugging helper concrete instance
     *
     * Debugging instance has helper function for
     * use in debugging code
     *
     * @return Debugging
     */
    public static function debugging():Debugging
    {
        if(isset(self::$instances[Debugging::class]))
            return self::$instances[Debugging::class];

        return self::$instances[Debugging::class] = new Debugging();
    }

    /**
     * Returns file helper concrete instance
     *
     * File helper concrete contains useful
     * functions for work with files and path
     *
     * @return File
     */
    public static function file():File
    {
        if(isset(self::$instances[File::class]))
            return self::$instances[File::class];

        return self::$instances[File::class] = new File;
    }


}