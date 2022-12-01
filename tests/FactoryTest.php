<?php

declare(strict_types=1);

namespace Brendt\Make\Tests;

use PHPUnit\Framework\TestCase;

final class FactoryTest extends TestCase
{
    /** @test */
    public function from_collection_with_arrays()
    {
        $posts = make(Post::class)->fromCollection([
            ['title' => 'a'],
            ['title' => 'b'],
        ]);

        $this->assertEquals('a', $posts[0]->title);
        $this->assertEquals('b', $posts[1]->title);
    }

    /** @test */
    public function from_array()
    {
        $post = make(Post::class)->from([
            'title' => 'test',
        ]);

        $this->assertEquals('test', $post->title);
    }

    /** @test */
    public function with_additional_data()
    {
        $post = make(Post::class)->from([
            'title' => 'test',
            'unknown' => 'unknown',
        ]);

        $this->assertFalse(isset($post->unknown));
    }

    /** @test */
    public function from_json()
    {
        $post = make(Post::class)->from(<<<JSON
            {
                "title": "test"
            }
        JSON);

        $this->assertEquals('test', $post->title);
    }

    /** @test */
    public function from_xml()
    {
        $post = make(Post::class)->from(<<<XML
            <post>
                <title>test</title>
            </post>
        XML);

        $this->assertEquals('test', $post->title);
    }

    /** @test */
    public function from_file()
    {
        $post = make(Post::class)->from(__DIR__ . '/post.json');

        $this->assertEquals('test', $post->title);
    }

    /** @test */
    public function from_makes()
    {
        $post = make(Post::class)->from(new PostRequest());

        $this->assertEquals('test', $post->title);
    }

    /** @test */
    public function with_nested_object()
    {
        $post = make(Post::class)->from([
            'title' => 'test',
            'tag' => [
                'name' => 'name',
            ],
        ]);

        $this->assertEquals('name', $post->tag->name);
    }

    /** @test */
    public function with_array_of_nested_object()
    {
        $post = make(Post::class)->from([
            'title' => 'test',
            'tags' => [
                ['name' => 'a'],
                ['name' => 'b'],
            ],
        ]);

        $this->assertEquals('a', $post->tags[0]->name);
        $this->assertEquals('b', $post->tags[1]->name);
    }
}
