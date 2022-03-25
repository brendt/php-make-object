<?php

declare(strict_types=1);

namespace Brendt\Make;

use Brendt\Make\Mappers\ArrayMapper;
use Brendt\Make\Mappers\FileMapper;
use Brendt\Make\Mappers\JsonMapper;
use Brendt\Make\Mappers\MakesMapper;
use Brendt\Make\Mappers\XmlMapper;
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
            ->addMapper(new MakesMapper($this))
            ->addMapper(new FileMapper($this))
            ->addMapper(new ArrayMapper($this->serializer, $this->className))
            ->addMapper(new JsonMapper($this->serializer, $this->className))
            ->addMapper(new XmlMapper($this->serializer, $this->className));
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

        return $mapper->map($input);
    }

    public function addMapper(Mapper $mapper): self
    {
        $this->mappers[] = $mapper;

        return $this;
    }

    private function resolveMapper(Makes|array|string $input): Mapper
    {
        foreach ($this->mappers as $mapper) {
            if ($mapper->matches($input)) {
                return $mapper;
            }
        }

        throw new Exception("No mapper found for {$input}");
    }
}
