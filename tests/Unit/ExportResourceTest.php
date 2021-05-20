<?php

namespace MediaConvert\Tests\Unit;

use MediaConvert\Models\Common;
use MediaConvert\Models\Export;

use GuzzleHttp\Psr7\Response;
use Http\Message\RequestMatcher\CallbackRequestMatcher;
use Psr\Http\Message\RequestInterface;

class ExportResourceTest extends TestCase
{
    public function testExportUrl()
    {
        $export = (new Export('export/url'));

        $response = new Response(200, [
            'Content-Type' => 'application/json'
        ], file_get_contents(__DIR__ . '/responses/export.json'));

        $this->getMockClient()->on(
            new CallbackRequestMatcher(function (RequestInterface $request) {
                if (strpos($request->getUri(), '/export/url') === false) {
                    return false;
                }
                return true;
            }), $response);

        $this->mediaConvert->exports()->create($export);

        $this->assertNotNull($export->getId());
        $this->assertEquals('export/url', $export->getOperation());
        $this->assertNotNull($export->getCreatedAt());
        $this->assertEquals(Common::STATUS_WAITING, $export->getStatus());
    }
}
