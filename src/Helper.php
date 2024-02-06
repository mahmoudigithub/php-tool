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
}