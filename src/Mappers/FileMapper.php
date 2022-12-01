<?php

declare(strict_types=1);

namespace Brendt\Make\Mappers;

use Brendt\Make\Factory;
use Brendt\Make\Makes;
use Brendt\Make\Mapper;

final class FileMapper
{
    public function __construct(
        private readonly Factory $factory,
    ) {}

    public function __invoke(string $input): object
    {
        if (!is_file($input)) {
            throw new InvalidMapper("Input isn't a file");
        }

        return $this->factory->from(file_get_contents($input));
    }
}
