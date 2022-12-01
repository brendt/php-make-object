# Simple wrapper for symfony/serializer for the 90% use-case

[![Latest Version on Packagist](https://img.shields.io/packagist/v/brendt/php-make-object.svg?style=flat-square)](https://packagist.org/packages/brendt/php-make-object)
[![Tests](https://github.com/brendt/php-make-object/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/brendt/php-make-object/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/brendt/php-make-object.svg?style=flat-square)](https://packagist.org/packages/brendt/php-make-object)

Write this:

```php
$post = make(Post::class)->from($postData);
```

instead of this:

```php
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

$serializer = new SymfonySerializer(
    normalizers: [
        $arrayNormalizer,
        $normalizer,
    ],
    encoders: [
        new XmlEncoder(),
        new JsonEncoder(),
    ],
);

$post = $serializer->denormalize($postData, Post::class)
```

## Installation

You can install the package via composer:

```bash
composer require brendt/php-make-object
```

## Usage

This package abstracts away all configuration needed for complex deserialization with [symfony/serializer](https://symfony.com/doc/current/components/serializer.html). All you need to do is say which class you want to make, provide it some input (arrays, JSON, XML, files or objects), and this package will take care of the rest.

Added bonus: proper static analysis, so you'll know what kind of object was created.

```php
$post = make(Post::class)->from($postData);
```

### Input types

#### Arrays

```php
$post = make(Post::class)->from([
    'title' => 'test',
]);
```

#### JSON

```php
$post = make(Post::class)->from(<<<JSON
    {
        "title": "test"
    }
JSON);
```

#### XML

```php
$post = make(Post::class)->from(<<<XML
    <post>
        <title>test</title>
    </post>
XML);
```

#### Files

```php
$post = make(Post::class)->from(__DIR__ . '/post.json');
```

#### The `Make` interface

The `Make` interface can be added on any class, allowing that class to provide data that can be used to create an object.

```php
$post = make(Post::class)->from(new PostRequest());
```

```php
final class PostRequest implements Makes
{
    public function data(): array
    {
        return [
            'title' => 'test',
        ];
    }
}
```

#### Collections

```php
$posts = make(Post::class)->fromCollection([
    ['title' => 'a'],
    ['title' => 'b'],
    ['title' => 'c'],
]);
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Credits

- [Brent Roose](https://github.com/brendt)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
