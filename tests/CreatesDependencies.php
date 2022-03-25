<?php

declare(strict_types=1);

namespace Brendt\Make\Tests;

use Brendt\Make\Factory;
use Brendt\Make\Serializer;
use Symfony\Component\Serializer\Serializer as SymfonySerializer;

trait CreatesDependencies
{
    protected function serializer(): SymfonySerializer
    {
        return Serializer::make();
    }

    protected function factory(): Factory
    {
        return Factory::make(Post::class);
    }
}
