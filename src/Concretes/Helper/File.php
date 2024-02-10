<?php

/**
 * This helper concrete contains helper functions
 * relates to file and storage operations such as
 * get file path, get root directory, etc.
 */

namespace Intech\Tool\Concretes\Helper;

use Intech\Tool\Helper;

class File implements IHelperConcrete
{
    /**
     * Bridge
     *
     * @param Helper $helper
     */
    public function __construct(
        private Helper $helper
    ){}

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
    public function reformat(string $path): string
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
    public function ls(string $directory, string $pattern = "*"): array|null
    {
        $list = glob($this->reformat($directory) . DIRECTORY_SEPARATOR . $pattern);

        if (!$list)
            return null;

        $namesList = [];

        foreach ($list as $path)
            $namesList[] = basename($path);

        return $namesList;
    }

    /**
     * Returns dirname of path
     *
     * @param string $path
     * @return string|null
     */
    public function dirname(string $path): string|null
    {
        if (!$dir = dirname($path))
            return null;

        return $this->reformat($dir);
    }

    /**
     * Returns app root directory
     *
     * It finds parent directory that
     * contains composer.json file and
     * vendor directory that has autoload.php
     * return its address as root directory
     * else returns null
     *
     * @return string|null
     */
    public function root(): string|null
    {
        $currentDir = null;

        do {
            $currentDir = !$currentDir ? $this->dirname(__DIR__) : $this->dirname($currentDir);

            if (!$currentDir || !$list = $this->ls($currentDir))
                return null;

            if (!in_array('composer.json', $list) or !in_array('vendor', $list))
                continue;

            $vendorPath = $this->reformat($currentDir . DIRECTORY_SEPARATOR . 'vendor');

            if (!$vendorList = $this->ls($vendorPath))
                return null;

            if (!in_array('autoload.php', $vendorList))
                continue;

            return $currentDir;

        } while (1);
    }
}