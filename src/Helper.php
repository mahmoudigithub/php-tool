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
    #[NoReturn] public static function dd(mixed $value):void
    {
        var_dump($value);

        exit;
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