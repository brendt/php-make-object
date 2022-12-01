<?php

declare(strict_types=1);

namespace Brendt\Make\Mappers;

use Symfony\Component\Serializer\Serializer;

final class ArrayMapper
{
    public function __construct(
        private readonly Serializer $serializer,
        private readonly string $className,
    ) {
    }

    public function __invoke(array $input): object
    {
        return $this->serializer->denormalize($input, $this->className);
    }
}
