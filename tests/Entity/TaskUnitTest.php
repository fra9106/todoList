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

    public function setUp() : void
    {
        $this->task = new Task();
        $this->date = new DateTime();
    }

    public function testId()
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

    public function testCreatedAt()
    {
        $this->task->setCreatedAt($this->date);
        $this->assertSame($this->date, $this->task->getCreatedAt());
    }

    public function testUser()
    {
        $this->task->setUser(new User());
        $this->assertInstanceOf(User::class, $this->task->getUser());
    }

    public function testIsEmpty()
    {
        $this->assertEmpty($this->task->getTitle());
        $this->assertEmpty($this->task->getContent());
        $this->assertEmpty($this->task->getUser());
    }

}
