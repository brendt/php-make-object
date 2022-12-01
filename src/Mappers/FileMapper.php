<?php

declare(strict_types=1);

namespace Brendt\Make\Mappers;

use Brendt\Make\Factory;
use Brendt\Make\Mapper;

final class FileMapper implements Mapper
{
    public function __construct(
        private readonly Factory $factory
    ) {
    }

    public function matches(object|array|string $input): bool
    {
        return is_string($input) && is_file($input);
    }

    public function map(object|array|string $input): object
    {
        return $this->factory->from(file_get_contents($input));
    }
}
