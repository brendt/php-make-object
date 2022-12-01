<?php

declare(strict_types=1);

namespace Brendt\Make\Mappers;

use Brendt\Make\Makes;
use Brendt\Make\Mapper;
use Symfony\Component\Serializer\Serializer;

final class XmlMapper
{
    public function __construct(
        private readonly Serializer $serializer,
        private readonly string $className,
    ) {
    }

    public function __invoke(string $input): object
    {
        if (
            ! str_starts_with(trim($input), '<')
            || ! str_ends_with(trim($input), '>')
        ) {
            throw new InvalidMapper("Not a valid XML string");
        }

        return $this->serializer->deserialize($input, $this->className, 'xml');
    }
}
