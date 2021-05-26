<?php

namespace OnlineUniConvert\Tests\Feature;

use GuzzleHttp\Client;
use OnlineUniConvert\OnlineUniConvert;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var OnlineUniConvert
     */
    protected $OnlineUniConvert;

    public function setUp(): void
    {
        $this->OnlineUniConvert = new OnlineUniConvert([
            'apiHost' => 'http://48046449-1266070635367705.test.functioncompute.com/v2',
            'apiKey' => getenv('API_KEY'),
            'http_client' => new Client()
        ]);

        parent::setUp();
    }
}
