<?php

namespace OnlineUniConverter\Tests\Unit;

use OnlineUniConverter\Models\User;
use GuzzleHttp\Psr7\Response;
use Http\Message\RequestMatcher\RequestMatcher;

class UsersResourceTest extends TestCase
{
    public function testMe()
    {
        $response = new Response(200, [
            'Content-Type' => 'application/json'
        ], file_get_contents(__DIR__ . '/responses/user.json'));

        $this->getMockClient()->on(new RequestMatcher('/v2/me', null, 'GET'), $response);

        $user = $this->OnlineUniConverter->users()->me();

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals(38, $user->getMinutes());
        $this->assertEquals('00000000', $user->getWsId());
        $this->assertEquals('xxx@xx.cn', $user->getEmail());
    }
}
