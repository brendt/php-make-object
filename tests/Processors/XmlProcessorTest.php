<?php

declare(strict_types=1);

namespace Brendt\Make\Tests\Processors;

use Brendt\Make\Processors\XmlProcessor;
use PHPUnit\Framework\TestCase;

final class XmlProcessorTest extends TestCase
{
    public function test_it_only_supports_xml()
    {
        $processor = new XmlProcessor();

        $this->assertTrue(
            $processor->supports('<post><title>test</title></post>')
        );

        $this->assertFalse(
            $processor->supports(['post' => ['title' => 'test']])
        );
    }

    public function test_it_processes_xml()
    {
        $processor = new XmlProcessor();

        $this->assertEquals(
            ['title' => 'test'],
            $processor->process('<post><title>test</title></post>')
        );
    }
}
