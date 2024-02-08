<?php

/**
 * This test class will test File helper concrete
 */

namespace Tests\Helper;

use Tests\Helper\Traits\HasConcreteFactory;
use Tests\TestCase;
use Tests\Traits\HasAssetFactory;

class FileTest extends TestCase
{
    use HasConcreteFactory, HasAssetFactory;

    /**
     * Asserts reformat function removes double slash
     *
     * @return void
     */
    public function test_reformat_path_for_double_back_slash()
    {
        $path = "test//test1";

        $helper = $this->createFileHelper();

        $path = $helper->reformat($path);

        $this->assertSame("test/test1" ,$path);
    }

    /**
     * Asserts reformat function removes extra slash at end of path
     *
     * @return void
     */
    public function test_reformat_removes_slash_at_end_of_path()
    {
        $path = "test/test1/";

        $helper = $this->createFileHelper();

        $path = $helper->reformat($path);

        $this->assertSame("test/test1" ,$path);
    }

    /**
     * Assert reformat function doesn't remove slash at start of path
     *
     * @return void
     */
    public function test_reformat_does_not_remove_slash_at_start_of_path()
    {
        $path = "/test/test1";

        $helper = $this->createFileHelper();

        $path = $helper->reformat($path);

        $this->assertSame("/test/test1" ,$path);
    }

    /**
     * Asserts reformat function replaces forwards-lashes or backslashes with directory separator
     *
     * @return void
     */
    public function test_reformat_replace_forward_or_back_slash_with_directory_separator()
    {
        $path = DIRECTORY_SEPARATOR == '/' ? '\test\test1': '/test/test1';

        $helper = $this->createFileHelper();

        $path = $helper->reformat($path);

        $this->assertSame(DIRECTORY_SEPARATOR . 'test' . DIRECTORY_SEPARATOR . 'test1' ,$path);

    }

    /**
     * Asserts ls function returns list of files and directories in a directory with "directory/*" pattern
     *
     * @return void
     */
    public function test_ls_returns_list_of_all_of_files_and_directories()
    {
        $contents = [
            'test.txt',
            'test2.txt',
            'sub',
        ];

        $paths = [];

        foreach ($contents as $name)
            if(str_contains($name, '.'))
                $paths[] = $this->createFile($name);
            else
                $paths[] = $this->createDir($name);

        $helper = $this->createFileHelper();

        $res = $helper->ls($this->fakeDirectory());

        foreach ($paths as $path)
            $this->assertTrue(in_array($path, $res));
    }
}