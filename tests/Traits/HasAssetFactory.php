<?php

/**
 * Test trait uses for create directory and file for test
 */

namespace Tests\Traits;

trait HasAssetFactory
{
    /**
     * Returns fake directory that makes for build fake files and directories for test
     *
     * @return string
     */
    public function fakeDirectory(): string
    {
        $dir = __DIR__ . DIRECTORY_SEPARATOR . 'temp';

        if (!is_dir($dir))
            mkdir($dir, 0777, true);

        return $dir;
    }

    /**
     * Deletes fake directory
     *
     * @param string|null $path
     * @return bool
     */
    public function destroyFakeDirectory(?string $path = null): bool
    {
        $path = $path ?? $this->fakeDirectory();

        if (!file_exists($path))
            return true;

        if (!is_dir($path))
            return unlink($path);

        foreach (scandir($path) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!$this->destroyFakeDirectory($path . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }

        }

        return rmdir($path);
    }

    /**
     * Removes all contents of fake directory
     *
     * @param string|null $dir
     * @return bool
     */
    public function resetFakeDirectory(?string $dir = null): bool
    {
        $dir = $dir ?? $this->fakeDirectory();

        if (!is_dir($dir))
            return true;

        $objects = scandir($dir);

        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir . "/" . $object) == "dir")
                    $this->resetFakeDirectory($dir . "/" . $object);
                else unlink($dir . "/" . $object);
            }
        }
        reset($objects);

        return rmdir($dir);
    }

    /**
     * Makes fake file for test and returns its real path
     *
     * @param string $name
     * @param string $content
     * @return string
     */
    public function createFile(string $name, string $content = ""): string
    {
        $realPath = $this->fakeDirectory() . DIRECTORY_SEPARATOR . $name;

        file_put_contents($realPath, $content);

        return $realPath;
    }

    /**
     * Makes fake directory for test and returns its real path
     *
     * @param string $name
     * @return string
     */
    public function createDir(string $name):string
    {
        $realPath = $this->fakeDirectory() . DIRECTORY_SEPARATOR . $name;

        mkdir($realPath);

        return $realPath;
    }
}