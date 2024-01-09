<?php

namespace Intech\Tool;

use JetBrains\PhpStorm\NoReturn;

class Helper
{
    /**
     * Dump and die
     *
     * @param mixed $value
     * @return void
     */
    #[NoReturn] public function dd(mixed $value):void
    {
        var_dump($value);

        exit;
    }
}