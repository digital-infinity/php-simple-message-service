<?php

declare(strict_types=1);

namespace Queue\Documents;

use Queue\Exceptions\MessageNotFoundException;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\Document(collection: "queues")]
class Queue
{
    #[MongoDB\Id(strategy: "NONE", type: "string")]
    private string $queueName;

    /** @var Message[] */
    #[MongoDB\ReferenceMany(targetDocument: Message::class)]
    private array $messages = [];

    public function __construct(string $queueName)
    {
        $this->queueName = $queueName;
    }

    public function getAllMessages(): array
    {
        return $this->messages;
    }

    public function getMessage(string $messageId): Message
    {
        if (!isset($this->messages[$messageId])) {
            throw new MessageNotFoundException(sprintf("No message with ID %s exists in Queue %s.", $messageId, $this->queueName));
        }

        return $this->messages[$messageId];
    }

    public function addMessage(Message $message): void
    {
        $this->messages[$message->getId()] = $message;
    }

    public function getQueueName(): string
    {
        return $this->queueName;
    }

    public function setQueueName(string $queueName): void
    {
        $this->queueName = $queueName;
    }
}