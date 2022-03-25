<?php

declare(strict_types=1);

namespace Brendt\Make\Tests\Support\Data;

final class Tag
{
    public function __construct(
        public readonly string $name
    ) {
    }
}
