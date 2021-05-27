<?php

namespace OnlineUniConverter\Tests\Unit;

use OnlineUniConverter\Models\Common;

use GuzzleHttp\Psr7\Response;
use Http\Message\RequestMatcher\CallbackRequestMatcher;
use OnlineUniConverter\Models\Task;
use Psr\Http\Message\RequestInterface;

class TaskResourceTest extends TestCase
{
    public function testTaskConvert()
    {
        $task = (new Task('convert'))
            ->set('input', 'jnthak3k-amuk-bj8l-cj7h-nn1yno4jty8i')
            ->set('output_format', 'mp4');

        $response = new Response(200, [
            'Content-Type' => 'application/json'
        ], file_get_contents(__DIR__ . '/responses/task_convert.json'));

        $this->getMockClient()->on(
            new CallbackRequestMatcher(function (RequestInterface $request) {
                if (strpos($request->getUri(), 'convert') === false) {
                    return false;
                }
                $body = json_decode($request->getBody(), true);
                if ($body['input'] !== 'jnthak3k-amuk-bj8l-cj7h-nn1yno4jty8i'
                    || $body['output_format'] !== 'mp4') {
                    return false;
                }
                return true;
            }), $response);

        $this->OnlineUniConverter->tasks()->create($task);

        $this->assertNotNull($task->getId());
        $this->assertEquals('convert', $task->getOperation());
        $this->assertNotNull($task->getCreatedAt());
        $this->assertEquals(Common::STATUS_WAITING, $task->getStatus());
    }

    public function testTaskCompress()
    {
        $task = (new Task('compress'))
            ->set('input', 'jnthak3k-amuk-bj8l-cj7h-nn1yno4jty8i')
            ->set('output_format', 'mp4');

        $response = new Response(200, [
            'Content-Type' => 'application/json'
        ], file_get_contents(__DIR__ . '/responses/task_compress.json'));

        $this->getMockClient()->on(
            new CallbackRequestMatcher(function (RequestInterface $request) {
                if (strpos($request->getUri(), 'compress') === false) {
                    return false;
                }
                $body = json_decode($request->getBody(), true);
                if ($body['input'] !== 'jnthak3k-amuk-bj8l-cj7h-nn1yno4jty8i'
                    || $body['output_format'] !== 'mp4') {
                    return false;
                }
                return true;
            }), $response);

        $this->OnlineUniConverter->tasks()->create($task);

        $this->assertNotNull($task->getId());
        $this->assertEquals('compress', $task->getOperation());
        $this->assertNotNull($task->getCreatedAt());
        $this->assertEquals(Common::STATUS_WAITING, $task->getStatus());
    }
}
