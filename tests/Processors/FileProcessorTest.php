<?php

declare(strict_types=1);

namespace Brendt\Make\Tests\Processors;

use Brendt\Make\Processors\FileProcessor;
use Brendt\Make\Processors\JsonProcessor;
use Brendt\Make\Processors\Processor;
use PHPUnit\Framework\TestCase;

final class FileProcessorTest extends TestCase
{
    public function test_it_supports_only_files()
    {
        $processor = new Processor();

        $fileProcessor = new FileProcessor();
        $fileProcessor->setProcessor($processor);

        $this->assertTrue(
            $fileProcessor->supports(__DIR__ . '/../Support/files/post.json')
        );

        $this->assertFalse(
            $fileProcessor->supports(['title' => 'test'])
        );
    }

    public function test_it_processes_files()
    {
        $processor = new Processor([
            new JsonProcessor(),
        ]);

        $fileProcessor = new FileProcessor();
        $fileProcessor->setProcessor($processor);

        $this->assertEquals(
            ['title' => 'test'],
            $fileProcessor->process(__DIR__ . '/../Support/files/post.json')
        );
    }
}
