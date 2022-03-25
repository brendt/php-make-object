<?php

declare(strict_types=1);

namespace Brendt\Make\Mappers;

use Brendt\Make\Makes;
use Brendt\Make\Mapper;
use Symfony\Component\Serializer\Serializer;

final class ArrayMapper implements Mapper
{
    public function __construct(
        private readonly Serializer $serializer,
        private readonly string $className,
    ) {
    }

    public function matches(array|string|Makes $input): bool
    {
        return is_array($input);
    }

    public function map(array|string|Makes $input): object
    {
        return $this->serializer->denormalize($input, $this->className);
    }
}