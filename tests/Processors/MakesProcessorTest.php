<?php

declare(strict_types=1);

namespace Brendt\Make\Tests\Processors;

use Brendt\Make\Processors\MakesProcessor;
use Brendt\Make\Tests\Support\Makes\PostRequest;
use PHPUnit\Framework\TestCase;

final class MakesProcessorTest extends TestCase
{
    public function test_it_only_supports_makes_interface()
    {
        $processor = new MakesProcessor();

        $this->assertTrue(
            $processor->supports(new PostRequest())
        );

        $this->assertFalse(
            $processor->supports(['title' => 'test'])
        );
    }

    public function test_it_processes_makes_interface()
    {
        $processor = new MakesProcessor();

        $this->assertSame(
            ['title' => 'test'],
            $processor->process(new PostRequest())
        );
    }
}
