<?php

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserUnitTest extends TestCase
{
    private $user;

    public function setUp() : void
    {
        $this->user = new User();
    }

    public function testId()
    {
        $this->assertNull($this->user->getId());
    }

    public function testFirstName()
    {
        $this->user->setFirstName('first_name');
        $this->assertSame('first_name', $this->user->getFirstName());
        $this->assertTrue($this->user->getFirstName() === 'first_name');
        $this->assertFalse($this->user->getFirstName() === 'false');
        
    }

    public function testLastName()
    {
        $this->user->setLastName('last_name');
        $this->assertSame('last_name', $this->user->getLastName());
        $this->assertTrue($this->user->getLastName() === 'last_name');
        $this->assertFalse($this->user->getLastName() === 'false');
    }

    public function testEmail()
    {
        $this->user->setEmail('true@test.fr');
        $this->assertSame('true@test.fr', $this->user->getEmail());
        $this->assertTrue($this->user->getEmail() === 'true@test.fr');
        $this->assertFalse($this->user->getEmail() === 'false@test.fr');
    }

    public function testPassword()
    {
        $this->user->setPassword('password');
        $this->assertSame('password', $this->user->getPassword());
        $this->assertTrue($this->user->getPassword() === 'password');
        $this->assertFalse($this->user->getPassword() === 'false');
    }

    public function testRolesUser()
    {
        $this->user->setRoles(['ROLE_USER']);
        $this->assertSame(['ROLE_USER'], $this->user->getRoles());
        $this->assertTrue($this->user->getRoles([]) === ['ROLE_USER']);
        $this->assertFalse($this->user->getRoles([]) === 'false');
    }

    public function testSalt()
    {
        $this->assertNull($this->user->getSalt());
    }

    public function testEraseCredentials()
    {
        $this->assertNull($this->user->eraseCredentials());
    }


    public function testIsEmpty()
    {
        $this->assertEmpty($this->user->getFirstName());
        $this->assertEmpty($this->user->getLastName());
        $this->assertEmpty($this->user->getEmail());
        $this->assertEmpty($this->user->getPassword());
    }

}
