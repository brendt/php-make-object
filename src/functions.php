<?php

declare(strict_types=1);

use Brendt\Make\Factory;
use Brendt\Make\PendingObject;

if (! function_exists('make')) {

    /**
     * @template ClassName
     * @param class-string<ClassName> $className
     * @return \Brendt\Make\PendingObject<ClassName>
     */
    function make(string $className): PendingObject
    {
        return Factory::make($className);
    }
}
