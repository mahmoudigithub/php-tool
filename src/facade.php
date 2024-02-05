<?php

/**
 * Getter and setter for .env parameters
 *
 * @param string $name
 * @param mixed|null $value
 * @return string|null
 */
if(!function_exists('env')){
    function env(string $name, mixed $value = null):?string
    {
        if($value){
            $_ENV[$name] = $value;
            return $value;
        }

        return $_ENV[$name] ?? null;
    }
}