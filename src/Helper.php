<?php

namespace Intech\Tool;

use Intech\Tool\Concretes\Helper\Debugging;
use Intech\Tool\Concretes\Helper\File;
use JetBrains\PhpStorm\NoReturn;

class Helper
{
    /**
     * Singleton property for concrete instances
     *
     * Uses for keep instantiated helper concretes
     * for prevent re-instantiate
     *
     * @var array
     */
    private static array $concretes;

    /**
     * Singleton property for current class instance
     *
     * Uses for keep instantiated helper instance
     * for prevent re-instantiate
     *
     * @var Helper
     */
    private static Helper $singleton;

    /**
     * Singleton method for get current class instance
     * 
     * @return Helper
     */
    public static function instance():Helper
    {
        if(!isset(self::$singleton))
            self::$singleton = new self;

        return self::$singleton;
    }

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
        if(isset(self::$concretes[Debugging::class]))
            return self::$concretes[Debugging::class];

        return self::$concretes[Debugging::class] = new Debugging(self::instance());
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
        if(isset(self::$concretes[File::class]))
            return self::$concretes[File::class];

        return self::$concretes[File::class] = new File(self::instance());
    }


}