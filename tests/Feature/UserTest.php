<?php

namespace OnlineUniConverter\Tests\Feature;

use OnlineUniConverter\Models\User;

class UserTest extends TestCase
{
    public function testMe()
    {
        $user = $this->OnlineUniConverter->users()->me();

        $this->assertInstanceOf(User::class, $user);
        $this->assertNotNull($user->getWsId());
        $this->assertNotNull($user->getEmail());
        $this->assertNotNull($user->getMinutes());
    }
}
