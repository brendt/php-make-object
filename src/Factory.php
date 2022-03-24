<?php

namespace Brendt\Make;

use Closure;
use Exception;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @template ClassType
 */
final class Factory
{
    private readonly Serializer $serializer;

    private readonly string $className;

    /** @var \Brendt\Make\Mapper[] */
    private array $mappers = [];

    public function __construct(string $className)
    {
        $this->className = $className;

        $this->serializer = new Serializer(
            normalizers: [
                new ObjectNormalizer(),
            ],
            encoders: [
                new XmlEncoder(),
                new JsonEncoder(),
            ],
        );

        $this
            ->addMapper(new Mapper(
                match: fn (Makes|array|string $input) => $input instanceof Makes,
                result: fn (Makes $input) => $this->from($input->data()),
            ))
            ->addMapper(new Mapper(
                match: fn (Makes|array|string $input) => is_array($input),
                result: fn (array $input) => $this->serializer->denormalize($input, $this->className),
            ))
            ->addMapper(new Mapper(
                match: fn (Makes|array|string $input) => is_file($input),
                result: fn (string $input) => $this->from(file_get_contents($input)),
            ))
            ->addMapper(new Mapper(
                match: fn (Makes|array|string $input) => str_starts_with(trim($input), '<') && str_ends_with(trim($input), '>'),
                result: fn (string $input) => $this->serializer->deserialize($input, $this->className, 'xml'),
            ))
            ->addMapper(new Mapper(
                match: fn (Makes|array|string $input) => true,
                result: fn (string $input) => $this->serializer->deserialize($input, $this->className, 'json'),
            ));
    }

    /**
     * @param class-string<ClassType> $className
     *
     * @return self<ClassType>
     */
    public static function make(string $className): self
    {
        return new self($className);
    }

    /**
     * @return ClassType
     */
    public function from(Makes|array|string $input): object
    {
        $mapper = $this->resolveMapper($input);

        return $mapper($input);
    }

    public function addMapper(Mapper $mapper): self
    {
        $this->mappers[] = $mapper;

        return $this;
    }

    private function resolveMapper(Makes|array|string $input): Closure
    {
        foreach ($this->mappers as $mapper) {
            if (($mapper->match)($input)) {
                return $mapper->result;
            }
        }

        throw new Exception("No mapper found for {$input}");
    }
}
