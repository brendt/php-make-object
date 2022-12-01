<?php

declare(strict_types=1);

namespace Brendt\Make;

use Brendt\Make\Processors\ArrayProcessor;
use Brendt\Make\Processors\FileProcessor;
use Brendt\Make\Processors\JsonProcessor;
use Brendt\Make\Processors\MakesProcessor;
use Brendt\Make\Processors\Processor;
use Brendt\Make\Processors\ProcessorInterface;
use Brendt\Make\Processors\XmlProcessor;
use Symfony\Component\Serializer\Serializer as SymfonySerializer;

/**
 * @template ClassType
 */
final class Factory
{
    /** @var array<array-key,ProcessorInterface> */
    private static array $processors = [];

    public function __construct(
        private readonly ProcessorInterface $processor,
        private readonly SymfonySerializer $serializer
    ) {
        //
    }

    public static function registerProcessor(ProcessorInterface $processor)
    {
        self::$processors[] = $processor;
    }

    /**
     * @param class-string<ClassType> $className
     *
     * @return PendingObject<ClassType>
     */
    public static function make(string $className): PendingObject
    {
        $defaultProcessors = new Processor(
            array_merge(self::$processors, [
                new ArrayProcessor(),
                new FileProcessor(),
                new JsonProcessor(),
                new MakesProcessor(),
                new XmlProcessor(),
            ])
        );

        $factory = new self($defaultProcessors, Serializer::make());

        return $factory->build($className);
    }

    /**
     * @param class-string<ClassType> $className
     * @return PendingObject<ClassType>
     */
    public function build(string $className): PendingObject
    {
        return new PendingObject(
            processor: $this->processor,
            serializer: $this->serializer,
            class: $className
        );
    }
}
