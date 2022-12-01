<?php

declare(strict_types=1);

namespace Brendt\Make\Processors;

final class JsonProcessor implements ProcessorInterface
{
    public function supports(mixed $input): bool
    {
        if (! is_string($input)) {
            return false;
        }

        $input = trim($input);

        return (
            str_starts_with($input, '{') && str_ends_with($input, '}') ||
            str_starts_with($input, '[') && str_ends_with($input, ']')
        );
    }

    /**
     * @param string $input
     */
    public function process(mixed $input): array
    {
        return json_decode($input, true);
    }
}
