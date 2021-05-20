<?php

namespace MediaConvert\Tests\Feature;

use GuzzleHttp\Client;
use MediaConvert\MediaConvert;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var MediaConvert
     */
    protected $mediaConvert;

    public function setUp(): void
    {
        $this->mediaConvert = new MediaConvert([
            'apiKey' => getenv('API_KEY'),
            'http_client' => new Client()
        ]);

        parent::setUp();
    }
}
