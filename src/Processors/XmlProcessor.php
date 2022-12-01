<?php

declare(strict_types=1);

namespace Brendt\Make\Processors;

use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Serializer;

final class XmlProcessor implements ProcessorInterface
{
    private Serializer $serializer;

    public function __construct(?Serializer $serializer = null)
    {
        $this->serializer = (
            $serializer ??
            new Serializer([], [new XmlEncoder()])
        );
    }

    public function supports(mixed $input): bool
    {
        if (! is_string($input)) {
            return false;
        }

        $input = trim($input);

        return str_starts_with($input, '<') && str_ends_with($input, '>');
    }

    public function process(mixed $input): array
    {
        return $this->serializer->decode($input, 'xml');
    }
}
