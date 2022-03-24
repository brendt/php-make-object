<?php

namespace Brendt\Make;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @template ClassName
 */
final class Factory
{
    private readonly Serializer $serializer;

    public function __construct(
        private readonly string $className,
    ) {
        $this->serializer = new Serializer(
            normalizers: [
                new ObjectNormalizer()
            ],
            encoders: [
                new XmlEncoder(),
                new JsonEncoder(),
            ],
        );
    }

    /**
     * @param class-string<ClassName> $className
     * @return self<ClassName>
     */
    public static function make(string $className): self
    {
        return new self($className);
    }

    /**
     * @return ClassName
     */
    public function from(Makes|array|string $input): object
    {
        if ($input instanceof Makes) {
            $input = $input->data();
        }

        if (is_array($input)) {
           return $this->serializer->denormalize($input, $this->className);
        }

        if (is_file($input)) {
            $input = file_get_contents($input);
        }

        $format = 'json';

        $input = trim($input);

        if (str_starts_with($input, '<') && str_ends_with($input, '>')) {
            $format = 'xml';
        }

        return $this->serializer->deserialize($input, $this->className, $format);
    }
}
