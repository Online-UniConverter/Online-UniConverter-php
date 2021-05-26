<?php

namespace OnlineUniConvert\Models;

class User
{
    /**
     * @var string
     */
    protected $wsId;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var int
     */
    protected $remain_minutes;

    /**
     * @var \DateTimeImmutable
     */
    protected $created_at;

    /**
     * @var array
     */
    protected $links;

    /**
     * @return string
     */
    public function getWsId(): string
    {
        return $this->wsId;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return int
     */
    public function getMinutes(): int
    {
        return $this->remain_minutes;
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
}
