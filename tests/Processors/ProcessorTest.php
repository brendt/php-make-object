<?php

declare(strict_types=1);

namespace Brendt\Make\Tests\Processors;

use Brendt\Make\Processors\JsonProcessor;
use Brendt\Make\Processors\Processor;
use Brendt\Make\Processors\ProcessorInterface;
use Brendt\Make\Processors\XmlProcessor;
use Exception;
use Mockery;
use PHPUnit\Framework\TestCase;

final class ProcessorTest extends TestCase
{
    use \Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

    public function test_it_can_set_processors()
    {
        $processors = [
            new JsonProcessor(),
            new XmlProcessor(),
        ];

        $processor = new Processor();
        $processor->setProcessors($processors);

        $this->assertSame($processors, $processor->getProcessors());
    }

    public function test_it_can_add_processor_aware_processors()
    {
        $processor = new Processor();

        $processorAware = Mockery::mock('\Brendt\Make\Processors\ProcessorInterface, \Brendt\Make\Processors\ProcessorAwareInterface');
        $processorAware->expects('setProcessor')->once()->with($processor);

        $processor->addProcessor($processorAware);
    }

    public function test_it_supports_data_if_child_processor_supports_data()
    {
        $json = '{"title":"testing"}';

        $xmlProcessor = Mockery::mock(ProcessorInterface::class);
        $xmlProcessor->expects('supports')->once()->with($json)->andReturnFalse();

        $jsonProcessor = Mockery::mock(ProcessorInterface::class);
        $jsonProcessor->expects('supports')->once()->with($json)->andReturnTrue();

        $processor = new Processor([
            $xmlProcessor,
            $jsonProcessor,
        ]);

        $this->assertTrue(
            $processor->supports($json)
        );
    }

    public function test_it_does_not_support_data_if_child_processors_do_not_support_data()
    {
        $array = ['title' => 'testing'];

        $xmlProcessor = Mockery::mock(ProcessorInterface::class);
        $xmlProcessor->expects('supports')->once()->with($array)->andReturnFalse();

        $jsonProcessor = Mockery::mock(ProcessorInterface::class);
        $jsonProcessor->expects('supports')->once()->with($array)->andReturnFalse();

        $processor = new Processor([
            $xmlProcessor,
            $jsonProcessor,
        ]);

        $this->assertFalse(
            $processor->supports($array)
        );
    }

    public function test_it_processes_data()
    {
        $json = '{"title":"Test"}';

        $processor = new Processor([
            new JsonProcessor(),
        ]);

        $this->assertEquals(
            ['title' => 'Test'],
            $processor->process($json)
        );
    }

    public function test_it_throws_exception_when_no_processor_supports_data()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('No processor was registered for this data type.');

        $array = ['title' => 'Test'];

        $processor = new Processor([
            new JsonProcessor(),
            new XmlProcessor(),
        ]);

        $processor->process($array);
    }
}
