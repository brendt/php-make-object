<?php

declare(strict_types=1);

namespace Brendt\Make\Tests\Support\Data;

final class Post
{
    /** @var \Brendt\Make\Tests\Support\Data\Tag[] */
    public array $tags;

    public function __construct(
        public readonly string $title,
        public readonly ?Tag $tag = null,
        array $tags = [],
    ) {
        $this->tags = $tags;
    }
}
