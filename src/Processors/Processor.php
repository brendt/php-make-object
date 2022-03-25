<?php

declare(strict_types=1);

namespace Brendt\Make\Processors;

use Exception;

final class Processor implements ProcessorInterface
{
    private array $processors = [];

    public function __construct(array $processors = [])
    {
        $this->setProcessors($processors);
    }

    public function supports(mixed $input): bool
    {
        foreach ($this->getProcessors() as $processor) {
            if (! $processor->supports($input)) {
                continue;
            }

            return true;
        }

        return false;
    }

    public function process(mixed $input): array
    {
        foreach ($this->getProcessors() as $processor) {
            if (! $processor->supports($input)) {
                continue;
            }

            return $processor->process($input);
        }

        throw new Exception('No processor was registered for this data type.');
    }

    public function addProcessor(ProcessorInterface $processor): void
    {
        if ($processor instanceof ProcessorAwareInterface) {
            $processor->setProcessor($this);
        }

        $this->processors[] = $processor;
    }

    /**
     * @param array<array-key,ProcessorInterface> $processors
     */
    public function setProcessors(array $processors): void
    {
        foreach ($processors as $processor) {
            $this->addProcessor($processor);
        }
    }

    /**
     * @return array<array-key,ProcessorInterface>
     */
    public function getProcessors(): array
    {
        return $this->processors;
    }
}
