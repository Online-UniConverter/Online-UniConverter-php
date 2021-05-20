<?php

namespace MediaConvert\Tests\Feature;

use MediaConvert\Models\User;

class UserTest extends TestCase
{
    public function testMe()
    {
        $user = $this->mediaConvert->users()->me();

        $this->assertInstanceOf(User::class, $user);
        $this->assertNotNull($user->getWsId());
        $this->assertNotNull($user->getEmail());
        $this->assertNotNull($user->getMinutes());
    }
}
