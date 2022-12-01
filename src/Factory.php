<?php

declare(strict_types=1);

namespace Brendt\Make;

use Brendt\Make\Mappers\ArrayMapper;
use Brendt\Make\Mappers\FileMapper;
use Brendt\Make\Mappers\JsonMapper;
use Brendt\Make\Mappers\MakesMapper;
use Brendt\Make\Mappers\ObjectMapper;
use Brendt\Make\Mappers\XmlMapper;
use Exception;
use Illuminate\Support\Collection;
use Symfony\Component\Serializer\Serializer as SymfonySerializer;

/**
 * @template ClassType
 */
final class Factory
{
    private readonly SymfonySerializer $serializer;

    private readonly string $className;

    /** @var \Brendt\Make\Mapper[] */
    private array $mappers = [];

    public function __construct(string $className)
    {
        $this->className = $className;

        $this->serializer = Serializer::make();

        $this
            ->addMapper(new MakesMapper($this))
            ->addMapper(new FileMapper($this))
            ->addMapper(new ArrayMapper($this->serializer, $this->className))
            ->addMapper(new JsonMapper($this->serializer, $this->className))
            ->addMapper(new XmlMapper($this->serializer, $this->className))
            ->addMapper(new ObjectMapper($this))
        ;
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
    public function from(array|object|string $input): object
    {
        $mapper = $this->resolveMapper($input);

        return $mapper->map($input);
    }

    /**
     * @param array $input
     * @return \Illuminate\Support\Collection<int, ClassType>
     */
    public function fromCollection(array $input): Collection
    {
        return collect($input)->map(fn (mixed $input) => $this->from($input));
    }

    public function addMapper(Mapper $mapper): self
    {
        $this->mappers[] = $mapper;

        return $this;
    }

    private function resolveMapper(object|array|string $input): Mapper
    {
        foreach ($this->mappers as $mapper) {
            if ($mapper->matches($input)) {
                return $mapper;
            }
        }

        throw new Exception("No mapper found for {$input}");
    }
}
