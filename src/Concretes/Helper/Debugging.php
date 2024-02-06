<?php

namespace Intech\Tool\Concretes\Helper;

use JetBrains\PhpStorm\NoReturn;

class Debugging
{
    /**
     * Dump and die
     *
     * @param mixed $value
     * @return void
     */
    #[NoReturn] public static function dd(mixed $value):void
    {
        var_dump($value);

        exit;
    }
}