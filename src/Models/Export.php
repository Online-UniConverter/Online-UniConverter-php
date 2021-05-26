<?php

namespace OnlineUniConvert\Models;

class Export
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var string
     */
    protected $operation;

    /**
     * @var \DateTimeImmutable
     */
    protected $created_at;

    /**
     * @var \DateTimeImmutable|null
     */
    protected $started_at;

    /**
     * @var \DateTimeImmutable|null
     */
    protected $ended_at;

    /**
     * @var array
     */
    protected $links;

    /**
     * @var object|null
     */
    protected $payload;

    /**
     * @var object|null
     */
    protected $result;

    /**
     * Import constructor.
     *
     * @param string|null $operation
     */
    public function __construct(string $operation = null)
    {
        $this->operation = 'export/' . $operation;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getOperation(): string
    {
        return $this->operation;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->created_at;
    }

    /**
     * @return array
     */
    public function getLinks(): array
    {
        return $this->links;
    }

    /**
     * @return object|null
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @return object|null
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getStartedAt(): ?\DateTimeImmutable
    {
        return $this->started_at;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getEndedAt(): ?\DateTimeImmutable
    {
        return $this->ended_at;
    }

    /**
     * Set a task payload parameter
     *
     * @param string $parameter
     * @param        $value
     *
     * @return $this
     */
    public function set(string $parameter, $value)
    {
        if (!$this->payload) {
            $this->payload = [];
        }
        $this->payload[$parameter] = $value;
        return $this;
    }
}
