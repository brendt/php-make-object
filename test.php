<?php

/**
 * @template ClassName
 */
class ClassMaker
{
    private ?string $className = null;

    /**
     * @param class-string<ClassName> $className
     * @return self<ClassName>
     */
    public function forClass(string $className): self
    {
        $clone = clone $this;

        $clone->className = $className;

        return $clone;
    }

    /**
     * @return ClassName
     */
    public function make(): object
    {
        return new ($this->className)();
    }
}

class Foo {
    public string $bar = 'test';
}

$classMaker = new ClassMaker();

$classMaker->forClass(Foo::class)->make()->b;
