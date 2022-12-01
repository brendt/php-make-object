<?php

declare(strict_types=1);

namespace Brendt\Make\Mappers;

use Brendt\Make\Makes;
use Brendt\Make\Mapper;
use Symfony\Component\Serializer\Serializer;

final class JsonMapper implements Mapper
{
    public function __construct(
        private readonly Serializer $serializer,
        private readonly string $className,
    ) {
    }

    public function matches(object|array|string $input): bool
    {
        return is_string($input) && str_starts_with(trim($input), '{') && str_ends_with(trim($input), '}');
    }

    public function map(object|array|string $input): object
    {
        return $this->serializer->deserialize($input, $this->className, 'json');
    }
}
