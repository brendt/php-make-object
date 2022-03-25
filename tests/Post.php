<?php

declare(strict_types=1);

namespace Brendt\Make\Tests;

/**
 * @property-read \Brendt\Make\Tests\Tag[] $tags
 */
final class Post
{
    public function __construct(
        public readonly string $title,
        public readonly ?Tag $tag = null,
        public readonly array $tags = [],
    ) {
    }
}
