<?php

namespace OnlineUniConvert\Tests\Feature;

use OnlineUniConvert\Models\User;

class UserTest extends TestCase
{
    public function testMe()
    {
        $user = $this->OnlineUniConvert->users()->me();

        $this->assertInstanceOf(User::class, $user);
        $this->assertNotNull($user->getWsId());
        $this->assertNotNull($user->getEmail());
        $this->assertNotNull($user->getMinutes());
    }
}
