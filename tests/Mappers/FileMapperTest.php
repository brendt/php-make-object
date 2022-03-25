<?php

declare(strict_types=1);

namespace Brendt\Make\Tests\Mappers;

use Brendt\Make\Mappers\FileMapper;
use Brendt\Make\Tests\CreatesDependencies;
use Brendt\Make\Tests\Post;
use Brendt\Make\Tests\PostRequest;
use PHPUnit\Framework\TestCase;

final class FileMapperTest extends TestCase
{
    use CreatesDependencies;

    /** @test */
    public function test_matches()
    {
        $mapper = new FileMapper($this->factory());

        $this->assertTrue($mapper->matches(__DIR__ . '/../post.json'));
        $this->assertFalse($mapper->matches('test'));
        $this->assertFalse($mapper->matches(['title' => 'test']));
        $this->assertFalse($mapper->matches('{"title": "test"}'));
        $this->assertFalse($mapper->matches('<post><title>test</title></post>'));
        $this->assertFalse($mapper->matches(new PostRequest()));
    }

    /** @test */
    public function test_map()
    {
        $mapper = new FileMapper($this->factory());

        $this->assertInstanceOf(Post::class, $mapper->map(__DIR__ . '/../post.json'));
    }
}
