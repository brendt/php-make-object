<?php

declare(strict_types=1);

namespace Brendt\Make\Tests\Processors;

use Brendt\Make\Processors\JsonProcessor;
use PHPUnit\Framework\TestCase;

final class JsonProcessorTest extends TestCase
{
    public function test_it_only_supports_json()
    {
        $processor = new JsonProcessor();

        $this->assertTrue(
            $processor->supports('{"name":"Dwight"}')
        );

        $this->assertTrue(
            $processor->supports('[{"name":"Dwight"},{"name":"Jim"}]')
        );

        $this->assertFalse(
            $processor->supports(['name' => 'Dwight'])
        );
    }

    public function test_it_processes_json()
    {
        $processor = new JsonProcessor();

        $this->assertEquals(
            ['name' => 'Dwight'],
            $processor->process('{"name":"Dwight"}')
        );
    }
}
