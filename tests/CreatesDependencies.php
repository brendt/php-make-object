<?php

declare(strict_types=1);

namespace Brendt\Make\Tests;

use Brendt\Make\Factory;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

trait CreatesDependencies
{
    protected function serializer(): Serializer
    {
        return new Serializer(
            normalizers: [
                new ObjectNormalizer(),
            ],
            encoders: [
                new XmlEncoder(),
                new JsonEncoder(),
            ],
        );
    }

    protected function factory(): Factory
    {
        return Factory::make(Post::class);
    }
}
