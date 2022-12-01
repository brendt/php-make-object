<?php

declare(strict_types=1);

namespace Brendt\Make\Mappers;

use Symfony\Component\Serializer\Serializer;

final class JsonMapper
{
    public function __construct(
        private readonly Serializer $serializer,
        private readonly string $className,
    ) {
    }

    public function __invoke(string $input): object
    {
        json_decode($input);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new CannotMap('Not a valid JSON string');
        }

        return $this->serializer->deserialize($input, $this->className, 'json');
    }
}
