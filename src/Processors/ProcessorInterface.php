<?php

declare(strict_types=1);

namespace Brendt\Make\Processors;

interface ProcessorInterface
{
    public function supports(mixed $input): bool;

    public function process(mixed $input): array;
}
