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
            'apiKey' => getenv('API_KEY'),
            'http_client' => new Client()
        ]);

        parent::setUp();
    }
}
