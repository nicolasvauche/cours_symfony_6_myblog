<?php

namespace App\Tests\Unit\Entity\Blog;

use App\Entity\Blog\Post;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
    private Post $post;

    protected function setUp(): void
    {
        $this->post = new Post();
    }

    public function testId()
    {
        $this->assertNull($this->post->getId());
    }

    public function testTitle()
    {
        $title = "Test Title";
        $this->post->setTitle($title);
        $this->assertEquals($title, $this->post->getTitle());
    }

    public function testCover()
    {
        $cover = "cover.jpg";
        $this->post->setCover($cover);
        $this->assertEquals($cover, $this->post->getCover());
    }

    public function testContent()
    {
        $content = "Test Content";
        $this->post->setContent($content);
        $this->assertEquals($content, $this->post->getContent());
    }

    public function testCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $this->post->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $this->post->getCreatedAt());
    }

    public function testUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $this->post->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $this->post->getUpdatedAt());
    }

    public function testPublishedAt()
    {
        $publishedAt = new DateTimeImmutable();
        $this->post->setPublishedAt($publishedAt);
        $this->assertEquals($publishedAt, $this->post->getPublishedAt());
    }
}
