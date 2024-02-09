<?php

/**
 * This helper concrete contains helper functions
 * relates to file and storage operations such as
 * get file path, get root directory, etc.
 */

namespace Intech\Tool\Concretes\Helper;

class File
{
    /**
     * Reformat path and returns
     *
     * Removes extra characters from path.
     * For example removes spaces in start
     * and end of path
     *
     * @param string $path
     * @return string
     */
    public function reformat(string $path):string
    {
        $path = str_replace(['/', '\\', '//', '\\\\'], DIRECTORY_SEPARATOR, $path);

        return rtrim($path, '/\\ .');
    }

    /**
     * Returns list of files and directories of $directory path
     *
     * @param string $directory
     * @param string $pattern the pattern of file and directory name
     * that looking for
     * @return array|null return an array if $directory is exists path,
     * else returns null
     */
    public function ls(string $directory, string $pattern = "*"):array|null
    {
        return glob($this->reformat($directory) . DIRECTORY_SEPARATOR . $pattern);
    }

    /**
     * Returns dirname of path
     *
     * @param string $path
     * @return string|null
     */
    public function dirname(string $path):string|null
    {
        if(!$dir = dirname($path))
            return null;

        return $this->reformat($dir);
    }

    /**
     * Returns app root directory
     *
     * It finds parent directory that
     * contains composer.json file
     *
     * @return string|null
     */
    public function root():string|null
    {
        $currentDir = null;
        
        do{
            if(!$currentDir)
                if(!$currentDir = $this->dirname(__DIR__))
                    return null;

        } while(1);
    }
}