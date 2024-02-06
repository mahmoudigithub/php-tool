<?php

/**
 * This test class will test File helper concrete
 */

namespace Tests\Helper;

use PHPUnit\Framework\TestCase;
use Tests\Helper\Traits\HasConcreteFactory;

class FileTest extends TestCase
{
    use HasConcreteFactory;

    /**
     * This method tests reformat() helper function
     *
     * @return void
     */
    public function test_reformat_path_for_double_back_slash()
    {
        $path = "/test//test1";

        $helper = $this->createFileHelper();

        $path = $helper->reformat($path);

        $this->assertSame("/test/test1" ,$path);
    }
}