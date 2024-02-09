<?php

/**
 * Contains method factory of helper concretes
 */

namespace Tests\Helper\Traits;

use Intech\Tool\Concretes\Helper\File;
use Intech\Tool\Helper;

trait HasConcreteFactory
{
    /**
     * Returns File helper instance
     *
     * @return File
     */
    public function createFileHelper():File
    {
        return Helper::file();
    }

    /**
     * Returns file helper class name
     *
     * @return string
     */
    public function fileHelperClassname():string
    {
        return File::class;
    }
}