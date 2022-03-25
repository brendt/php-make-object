<?php

namespace Brendt\Make\Tests\Mappers;

use Brendt\Make\Mappers\FileMapper;
use Brendt\Make\Mappers\JsonMapper;
use Brendt\Make\Tests\CreatesDependencies;
use Brendt\Make\Tests\Post;
use Brendt\Make\Tests\PostRequest;
use PHPUnit\Framework\TestCase;

final class JsonMapperTest extends TestCase
{
    use CreatesDependencies;

    /** @test */
    public function test_matches()
    {
        $mapper = new JsonMapper($this->serializer(), Post::class);

        $this->assertTrue($mapper->matches('{"title": "test"}'));
        $this->assertFalse($mapper->matches(__DIR__ . '/../post.json'));
        $this->assertFalse($mapper->matches('test'));
        $this->assertFalse($mapper->matches(['title' => 'test']));
        $this->assertFalse($mapper->matches('<post><title>test</title></post>'));
        $this->assertFalse($mapper->matches(new PostRequest()));
    }

    /** @test */
    public function test_map()
    {
        $mapper = new JsonMapper($this->serializer(), Post::class);

        $this->assertInstanceOf(Post::class, $mapper->map('{"title": "test"}'));
    }
}
