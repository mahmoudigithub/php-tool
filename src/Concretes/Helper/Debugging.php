<?php

namespace Intech\Tool\Concretes\Helper;

use Intech\Tool\Helper;
use JetBrains\PhpStorm\NoReturn;

class Debugging implements IHelperConcrete
{
    /**
     * @param Helper $helper
     */
    public function __construct(
        private Helper $helper
    ){}

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