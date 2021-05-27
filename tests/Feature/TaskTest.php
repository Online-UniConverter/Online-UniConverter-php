<?php

namespace OnlineUniConverter\Tests\Feature;

use OnlineUniConverter\Models\Common;
use OnlineUniConverter\Models\Export;
use OnlineUniConverter\Models\Task;

class TaskTest extends TestCase
{
    public function testTaskConvert()
    {
        // init
        $task = (new Task('convert'))
            ->set('input', '2w2y610m-awgo-bt8q-cq2p-981fu1w1bmr0')
            ->set('output_format', 'mp4');
        $this->OnlineUniConverter->tasks()->create($task);
        $this->assertNotNull($task->getId());
        $this->assertNotNull($task->getCreatedAt());
        $this->assertEquals('convert', $task->getOperation());
        $this->assertEquals([
            'input' => '2w2y610m-awgo-bt8q-cq2p-981fu1w1bmr0',
            'output_format' => 'mp4',
        ], (array)$task->getPayload());
        $this->assertEquals(Common::STATUS_WAITING, $task->getStatus());

        // info
        $this->OnlineUniConverter->tasks()->info($task);
        $this->assertEquals(Common::STATUS_WAITING, $task->getStatus());
    }

    public function testTaskCompress()
    {
        // init
        $task = (new Task('compress'))
            ->set('input', '2w2y610m-awgo-bt8q-cq2p-981fu1w1bmr0')
            ->set('output_format', 'mp4')
            ->set('ratio', 0.6);
        $this->OnlineUniConverter->tasks()->create($task);
        $this->assertNotNull($task->getId());
        $this->assertNotNull($task->getCreatedAt());
        $this->assertEquals('compress', $task->getOperation());
        $this->assertEquals([
            'input' => '2w2y610m-awgo-bt8q-cq2p-981fu1w1bmr0',
            'output_format' => 'mp4',
            'ratio' => 0.6
        ], (array)$task->getPayload());
        $this->assertEquals(Common::STATUS_WAITING, $task->getStatus());

        // info
        $this->OnlineUniConverter->tasks()->info($task);
        $this->assertEquals(Common::STATUS_WAITING, $task->getStatus());
    }
}
