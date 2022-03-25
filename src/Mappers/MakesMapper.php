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

    public function matches(array|string|Makes $input): bool
    {
        return $input instanceof Makes;
    }

    public function map(array|string|Makes $input): object
    {
        return $this->factory->from($input->data());
    }
}
