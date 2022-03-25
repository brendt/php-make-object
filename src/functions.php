<?php

declare(strict_types=1);

use Brendt\Make\Factory;

if (! function_exists('make')) {

    /**
     * @template ClassName
     * @param class-string<ClassName> $className
     * @return \Brendt\Make\Factory<ClassName>
     */
    function make(string $className): Factory
    {
        return Factory::make($className);
    }
}
