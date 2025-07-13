<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\User;

class UserTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        $this->user = new User();
    }

    public function testEmailGetterSetter(): void
    {
        $email = 'test@example.com';
        $this->user->setEmail($email);

        $this->assertEquals($email, $this->user->getEmail());
        $this->assertEquals($email, $this->user->getUserIdentifier());
    }

    public function testPasswordGetterSetter(): void
    {
        $password = 'hashed_password';
        $this->user->setPassword($password);

        $this->assertEquals($password, $this->user->getPassword());
    }
    public function testToString(): void
    {

        $this->user->setEmail('test@example.com');
        $this->assertEquals('test@example.com', $this->user->__toString());
    }
}
