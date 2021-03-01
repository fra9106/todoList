<?php

namespace App\Tests;

use DateTime;
use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class TaskUnitTest extends TestCase
{
    private $task;
    private $date;
    private $user;

    public function setUp() : void
    {
        $this->task = new Task();
        $this->date = new DateTime();
        $this->user = new User();
    }

    public function testId() : void
    {
        $this->assertNull($this->task->getId());
    }

    public function testTitle()
    {
        $this->task->setTitle('title');
        $this->assertSame('title', $this->task->getTitle());
        $this->assertTrue($this->task->getTitle() === 'title');
        $this->assertFalse($this->task->getTitle() === 'false');
    }

    public function testContent()
    {
        $this->task->setContent('content');
        $this->assertSame('content', $this->task->getContent());
        $this->assertTrue($this->task->getContent() === 'content');
        $this->assertFalse($this->task->getContent() === 'false');
    }

    public function testIsDone()
    {
        $this->assertEquals(0, $this->task->IsDone());
    }

    public function testCreatedAt() 
    {
        $this->task->setCreatedAt($this->date);
        $this->assertSame($this->date, $this->task->getCreatedAt());
        $this->assertTrue($this->task->getCreatedAt() === $this->date);
        $this->assertFalse($this->task->getCreatedAt() === 'false');
    }

    public function testUser()
    {
        $this->task->setUser($this->user);
        $this->assertInstanceOf(User::class, $this->task->getUser());
        $this->assertTrue($this->task->getUser() === $this->user);
        $this->assertFalse($this->task->getUser() === 'false');
    }

    public function testIsEmpty()
    {
        $this->assertEmpty($this->task->getTitle());
        $this->assertEmpty($this->task->getContent());
        $this->assertEmpty($this->task->getUser());
    }

}
