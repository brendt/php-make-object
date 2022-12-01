<?php

declare(strict_types=1);

namespace Brendt\Make\Tests\Support\Makes;

use Brendt\Make\Makes;

final class PostRequest implements Makes
{
    public function data(): array
    {
        return [
            'title' => 'test',
        ];
    }
}
