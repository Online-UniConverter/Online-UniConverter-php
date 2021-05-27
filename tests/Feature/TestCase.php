<?php

namespace OnlineUniConverter\Tests\Feature;

use GuzzleHttp\Client;
use OnlineUniConverter\OnlineUniConverter;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var OnlineUniConverter
     */
    protected $OnlineUniConverter;

    public function setUp(): void
    {
        $this->OnlineUniConverter = new OnlineUniConverter([
            'apiHost' => 'http://48046449-1266070635367705.test.functioncompute.com/v2',
            'apiKey' => getenv('API_KEY'),
            'http_client' => new Client()
        ]);

        parent::setUp();
    }
}
