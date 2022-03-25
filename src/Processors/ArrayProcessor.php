<?php

declare(strict_types=1);

namespace Brendt\Make\Processors;

final class ArrayProcessor implements ProcessorInterface
{
    public function supports(mixed $input): bool
    {
        return is_array($input);
    }

    /**
     * @param array $input
     */
    public function process(mixed $input): array
    {
        return $input;
    }
}
