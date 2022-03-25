<?php

declare(strict_types=1);

namespace Brendt\Make;

use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer as SymfonySerializer;

final class Serializer
{
    public static function make(): SymfonySerializer
    {
        $reflectionExtractor = new ReflectionExtractor();

        $phpDocExtractor = new PhpDocExtractor();

        $propertyTypeExtractor = new PropertyInfoExtractor(
            listExtractors: [$reflectionExtractor],
            typeExtractors: [$phpDocExtractor, $reflectionExtractor],
            descriptionExtractors: [$phpDocExtractor],
            accessExtractors: [$reflectionExtractor],
            initializableExtractors: [$reflectionExtractor]
        );

        $normalizer = new ObjectNormalizer(
            propertyTypeExtractor: $propertyTypeExtractor
        );

        $arrayNormalizer = new ArrayDenormalizer();

        return new SymfonySerializer(
            normalizers: [
                $arrayNormalizer,
                $normalizer,
            ],
            encoders: [
                new XmlEncoder(),
                new JsonEncoder(),
            ],
        );
    }
}
