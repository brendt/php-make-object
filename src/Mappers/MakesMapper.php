<?php

declare(strict_types=1);

namespace Brendt\Make\Mappers;

use Brendt\Make\Factory;
use Brendt\Make\Makes;
use Brendt\Make\Mapper;

final class MakesMapper implements Mapper
{
    public function __construct(
        private readonly Factory $factory
    ) {
    }

    public function matches(object|array|string $input): bool
    {
        return $input instanceof Makes;
    }

    public function map(object|array|string $input): object
    {
        return $this->factory->from($input->data());
    }
}
