<?php

declare(strict_types=1);

namespace Brendt\Make\Tests\Processors;

use Brendt\Make\Processors\ArrayProcessor;
use PHPUnit\Framework\TestCase;

final class ArrayProcessorTest extends TestCase
{
    public function test_it_only_supports_arrays()
    {
        $processor = new ArrayProcessor();

        $this->assertTrue(
            $processor->supports(['name' => 'Dwight'])
        );

        $this->assertFalse(
            $processor->supports('{"name":"Dwight"}')
        );
    }

    public function test_it_processes_arrays()
    {
        $processor = new ArrayProcessor();

        $this->assertSame(
            ['name' => 'Dwight'],
            $processor->process(['name' => 'Dwight'])
        );
    }
}
