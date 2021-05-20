<?php

namespace MediaConvert\Tests\Unit;

use MediaConvert\Models\User;
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

        $user = $this->mediaConvert->users()->me();

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals(38, $user->getMinutes());
        $this->assertEquals('18083031', $user->getWsId());
        $this->assertEquals('shizhu@300624.cn', $user->getEmail());
    }
}
