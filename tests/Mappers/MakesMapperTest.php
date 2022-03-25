<?php

declare(strict_types=1);

namespace Brendt\Make\Tests\Mappers;

use Brendt\Make\Mappers\MakesMapper;
use Brendt\Make\Tests\CreatesDependencies;
use Brendt\Make\Tests\Post;
use Brendt\Make\Tests\PostRequest;
use PHPUnit\Framework\TestCase;

final class MakesMapperTest extends TestCase
{
    use CreatesDependencies;

    /** @test */
    public function test_matches()
    {
        $mapper = new MakesMapper($this->factory());

        $this->assertTrue($mapper->matches(new PostRequest()));
        $this->assertFalse($mapper->matches(__DIR__ . '/../post.json'));
        $this->assertFalse($mapper->matches('test'));
        $this->assertFalse($mapper->matches(['title' => 'test']));
        $this->assertFalse($mapper->matches('{"title": "test"}'));
        $this->assertFalse($mapper->matches('<post><title>test</title></post>'));
    }

    /** @test */
    public function test_map()
    {
        $mapper = new MakesMapper($this->factory());

        $this->assertInstanceOf(Post::class, $mapper->map(new PostRequest()));
    }
}
