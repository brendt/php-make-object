<?php

declare(strict_types=1);

namespace Brendt\Make;

interface Mapper
{
    public function matches(Makes|array|string $input): bool;

    public function map(Makes|array|string $input): object;
}
