<?php

declare(strict_types=1);

namespace Brendt\Make\Mappers;

use Brendt\Make\Factory;
use Brendt\Make\Makes;

final class MakesMapper
{
    public function __construct(
        private readonly Factory $factory
    ) {
    }

    public function __invoke(Makes $input): object
    {
        return $this->factory->from($input->data());
    }
}
