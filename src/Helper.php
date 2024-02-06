<?php

namespace Intech\Tool;

use Intech\Tool\Concretes\Helper\Debugging;
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
     * Returns debugging instance
     *
     * Debugging instance has helper function for
     * use in debugging code
     *
     * @return Debugging
     */
    public function debugging():Debugging
    {
        if(isset(self::$instances[Debugging::class]))
            return self::$instances[Debugging::class];

        return self::$instances[Debugging::class] = new Debugging();
    }

    /**
     * Returns app root directory
     *
     * It finds parent directory that
     * contains composer.json file
     *
     * @return string|null
     */
    public static function root():string|null
    {
        $cwd = __DIR__;

        $counter = 0;

        do{
            if(($cwd = dirname($cwd)) == '.')
                return null;

            if(in_array(
                $cwd . DIRECTORY_SEPARATOR . 'composer.json',
                glob($cwd . DIRECTORY_SEPARATOR . '*json')
            ))
                return $cwd;

        } while(1);
    }
}