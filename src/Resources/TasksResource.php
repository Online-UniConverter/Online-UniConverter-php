<?php

namespace OnlineUniConverter\Resources;

use OnlineUniConverter\Models\ImportUploadTask;
use OnlineUniConverter\Models\ImportUrlTask;
use OnlineUniConverter\Models\Task;

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
