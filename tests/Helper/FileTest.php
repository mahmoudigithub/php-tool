<?php

/**
 * This test class will test File helper concrete
 */

namespace Tests\Helper;

use Intech\Tool\Concretes\Helper\File;
use PHPUnit\Framework\MockObject\Exception;
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

        $names = $helper->ls($this->fakeDirectory(), "script*");

        foreach ($names as $name)
            $this->assertTrue(str_starts_with($name, 'script'));
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

    /**
     * Asserts root function returns false when there is no parent directory for current file directory
     *
     * @return void
     * @throws Exception
     */
    public function test_root_function_returns_false_when_there_is_no_parent_folder_for_current_executing_file_directory()
    {
        $helper = $this->createPartialMock(
            $this->fileHelperClassname(), ['dirname']);

        $helper->expects($this->once())
            ->method('dirname')
            ->willReturn(null);

        $this->assertNull($helper->root());
    }

    /**
     * Asserts root function helper returns path of parent directory of current file directory when that is according the conditions
     *
     * Test that helper returns path of parent directory of current executing file directory
     * when there is composer.json and vendor that has autoload.php
     *
     * @return void
     * @throws Exception
     */
    public function test_root_function_returns_parent_directory_path_of_current_executing_file_when_that_is_according_to_the_conditions()
    {
        $helper = $this->createPartialMock(
            $this->fileHelperClassname(), ['dirname', 'ls']);

        $helper->expects($this->once())
            ->method('dirname')
            ->willReturn('test/sub/parent');

        $helper->expects($this->exactly(2))
            ->method('ls')
            ->with('test/sub/parent')
            ->willReturn([
                'vendor',
                'composer.json'
            ])
            ->with('test/sub/parent/vendor')
            ->willReturn([
                'autoload.php'
            ]);

        $this->assertSame('test/sub/parent', $helper->root());
    }

    /**
     * Asserts root function helper returns null when that is according the conditions except autoload.php
     *
     * Test that helper returns path of parent directory of current executing file directory
     * when there is composer.json and vendor that has not autoload.php
     *
     * @return void
     * @throws Exception
     */
    public function test_root_function_returns_null_when_that_is_according_to_the_conditions_except_autoload()
    {
        $helper = $this->createPartialMock(
            $this->fileHelperClassname(), ['dirname', 'ls']);

        $helper->expects($this->exactly(2))
            ->method('dirname')
            ->with($this->any())
            ->willReturn('test/sub/parent')
            ->with('test/sub/parent')
            ->willReturn(null);

        $helper->expects($this->exactly(2))
            ->method('ls')
            ->with('test/sub/parent')
            ->willReturn([
                'vendor',
                'composer.json'
            ])
            ->with('test/sub/parent/vendor')
            ->willReturn([
                'somethings.txt',
                'autoload.txt',
            ]);

        $this->assertNull($helper->root());
    }

    /**
     * Asserts root function helper returns path of a directory when that is according the conditions
     *
     * Test that helper returns path a directory when there is composer.json and vendor that has
     * autoload.php in that directory
     *
     * @return void
     * @throws Exception
     */
    public function test_root_function_returns_a_directory_path_of_when_that_is_according_to_the_conditions()
    {
        $helper = $this->createPartialMock(
            $this->fileHelperClassname(), ['dirname', 'ls']);

        $helper->expects($this->once())
            ->method('dirname')
            ->with($this->any())
            ->willReturn('test/sub/parent')
            ->with('test/sub/parent')
            ->willReturn('test/sub');

        $helper->expects($this->exactly(2))
            ->method('ls')
            ->with('test/sub/parent')
            ->willReturn([
                'something.txt',
                'some'
            ])
            ->with('test/sub')
            ->willReturn([
                'vendor',
                'composer.json'
            ])
            ->with('test/sub/vendor')
            ->willReturn([
                'autoload.php'
            ]);

        $this->assertSame('test/sub', $helper->root());
    }

    /**
     * Asserts root function helper returns null when there is no directory that according the conditions
     *
     * @return void
     * @throws Exception
     */
    public function test_root_function_returns_null_when_there_is_no_directory_that_is_according_to_the_conditions()
    {
        $helper = $this->createPartialMock(
            $this->fileHelperClassname(), ['dirname', 'ls']);

        $helper->expects($this->once())
            ->method('dirname')
            ->with($this->any())
            ->willReturn('test/sub/parent')
            ->with('test/sub/parent')
            ->willReturn('test/sub');

        $helper->expects($this->exactly(2))
            ->method('ls')
            ->with('test/sub/parent')
            ->willReturn([
                'something.txt',
                'some'
            ])
            ->with('test/sub')
            ->willReturn([
                'vendor',
                'composer.json'
            ])
            ->with('test/sub/vendor')
            ->willReturn([
                'something.txt',
                'autoload.txt',
            ]);

        $this->assertSame('test/sub', $helper->root());
    }
}