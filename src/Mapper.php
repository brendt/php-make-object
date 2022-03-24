<?php

namespace Brendt\Make;

use Closure;

class Mapper
{
    /**
     * @param \Closure(\Brendt\Make\Makes|array|string $input): bool $match
     * @param \Closure(mixed $input): object $result
     */
    public function __construct(
        public readonly Closure $match,
        public readonly Closure $result,
    ) {
    }
}
