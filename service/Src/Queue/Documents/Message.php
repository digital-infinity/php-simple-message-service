<?php

declare(strict_types=1);

namespace Queue\Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Queue\Enums\Priority;
use Queue\Enums\Status;

#[MongoDB\Document(collection: "messages")]
class Message
{
    #[MongoDB\Id(strategy: "UUID", type: "string")]
    private string $id;

    #[MongoDB\Field(type: "int", enumType: Priority::class)]
    private Priority $priority;

    #[MongoDB\Field(type: "string")]
    private string $message;

    #[MongoDB\Field(type: "int", enumType: Status::class)]
    private Status $status;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void 
    {
        $this->id = $id;
    }

    public function setPriority(Priority $priority): void
    {
        $this->priority = $priority;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): void
    {
        $this->status = $status;
    }
}