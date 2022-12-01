<?php

declare(strict_types=1);

namespace Brendt\Make\Mappers;

use Brendt\Make\Factory;

final class ObjectMapper
{
    public function __construct(
        private readonly Factory $factory
    ) {
    }

    public function __invoke(object $input): object
    {
        return $this->factory->from((array) $input);
    }
}
