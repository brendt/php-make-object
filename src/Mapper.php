<?php

declare(strict_types=1);

namespace Brendt\Make;

interface Mapper
{
    public function matches(object|array|string $input): bool;

    public function map(object|array|string $input): object;
}
