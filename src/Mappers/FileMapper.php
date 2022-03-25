<?php

declare(strict_types=1);

namespace Brendt\Make\Mappers;

use Brendt\Make\Factory;
use Brendt\Make\Makes;
use Brendt\Make\Mapper;

final class FileMapper implements Mapper
{
    public function __construct(
        private readonly Factory $factory
    ) {
    }

    public function matches(array|string|Makes $input): bool
    {
        return is_string($input) && is_file($input);
    }

    public function map(array|string|Makes $input): object
    {
        return $this->factory->from(file_get_contents($input));
    }
}
