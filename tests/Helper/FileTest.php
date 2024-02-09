<?php

/**
 * This test class will test File helper concrete
 */

namespace Tests\Helper;

use Intech\Tool\Concretes\Helper\File;
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

    /**
     * Asserts ls function returns list of specific suffix files and directories
     *
     * @return void
     */
    public function test_ls_returns_list_of_specific_suffix_of_files_and_directories()
    {
        $contents = [
            'test.txt',
            'script.php',
            'sub_php',
        ];

        foreach ($contents as $name)
            if(str_contains($name, '.'))
                $this->createFile($name);
            else
                $this->createDir($name);

        $helper = $this->createFileHelper();

        $paths = $helper->ls($this->fakeDirectory(), "*php");

        foreach ($paths as $path)
            $this->assertTrue(str_ends_with($path, 'php'));
    }

    /**
     * Asserts ls function returns list of specific prefix files and directories
     *
     * @return void
     */
    public function test_ls_returns_list_of_specific_prefix_of_files_and_directories()
    {
        $contents = [
            'config.php',
            'script.txt',
            'script.php',
            'script_php',
        ];

        foreach ($contents as $name)
            if(str_contains($name, '.'))
                $this->createFile($name);
            else
                $this->createDir($name);

        $helper = $this->createFileHelper();

        $paths = $helper->ls($this->fakeDirectory(), "script*");

        foreach ($paths as $path)
            $this->assertTrue(str_starts_with(pathinfo($path, PATHINFO_FILENAME), 'script'));
    }

    /**
     * Asserts dirname helper function returns correct address
     *
     * @return void
     */
    public function test_dirname_function_returns_correct_path()
    {
        $path = $this->createFile('test.txt', 'It just for testing .');

        $helper = $this->createFileHelper();

        $this->assertSame(dirname($path), $helper->dirname($path));
    }
}