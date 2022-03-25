<?php

declare(strict_types=1);

namespace Brendt\Make;

use Brendt\Make\Processors\ProcessorInterface;
use Symfony\Component\Serializer\Serializer as SymfonySerializer;

/**
 * @template ClassType
 */
final class PendingObject
{
    /**
     * @param ProcessorInterface $processor
     * @param SymfonySerializer $serializer
     * @param class-string<ClassType> $class
     */
    public function __construct(
        private readonly ProcessorInterface $processor,
        private readonly SymfonySerializer $serializer,
        private readonly string $class
    ) {
        //
    }

    /**
     * @return ClassType
     */
    public function from(mixed $input): object
    {
        return $this->serializer->denormalize(
            $this->processor->process($input),
            $this->class
        );
    }
}
