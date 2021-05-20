<?php

namespace MediaConvert\Resources;

use MediaConvert\Models\ImportUploadTask;
use MediaConvert\Models\ImportUrlTask;
use MediaConvert\Models\Task;

class TasksResource extends AbstractResource
{
    /**
     * @param Task $task
     *
     * @return Task
     */
    public function create(Task $task): Task
    {
        $response = $this->httpTransport->post($this->httpTransport->getBaseUri() . '/' . $task->getOperation(), $task->getPayload() ?? []);
        return $this->hydrator->hydrateObjectByResponse($task, $response);
    }

    /**
     * @param Task $task
     *
     * @return Task
     */
    public function info(Task $task): Task
    {
        $response = $this->httpTransport->get($this->httpTransport->getBaseUri() . '/tasks/' . $task->getId());

        return $this->hydrator->hydrateObjectByResponse($task, $response);
    }
}
