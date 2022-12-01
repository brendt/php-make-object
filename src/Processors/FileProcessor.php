<?php

declare(strict_types=1);

namespace Brendt\Make\Processors;

final class FileProcessor implements ProcessorInterface, ProcessorAwareInterface
{
    private Processor $processor;

    public function setProcessor(Processor $processor): void
    {
        $this->processor = $processor;
    }

    public function supports(mixed $input): bool
    {
        return is_string($input) && file_exists($input);
    }

    /**
     * @param string $input
     */
    public function process(mixed $input): array
    {
        return $this->processor->process(
            file_get_contents($input)
        );
    }
}
