<?php

declare(strict_types=1);

namespace Brendt\Make\Processors;

use Brendt\Make\Makes;

final class MakesProcessor implements ProcessorInterface
{
    public function supports(mixed $input): bool
    {
        return $input instanceof Makes;
    }

    /**
     * @param Makes $input
     */
    public function process(mixed $input): array
    {
        return $input->data();
    }
}
