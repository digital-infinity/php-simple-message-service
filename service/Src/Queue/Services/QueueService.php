<?php

declare(strict_types=1);

namespace Queue\Services;

use Queue\Documents\Message;
use Queue\Documents\Queue;
use Queue\Documents\QueueList;
use Queue\Exceptions\MessageNotFoundException;
use Queue\Exceptions\QueueNotFoundException;

class QueueService
{
    private QueueList $queues;

    public function __construct()
    {
        $this->queues = new QueueList();
    }

    public function insertMessage(string $queue, Message $message): void
    {
        $this->queues->getQueue($queue)->addMessage($message);
    }

    /**
    * @throws QueueNotFoundException
    */
    public function getAllMessages(string $queueName): array
    {
        $queue = $this->queues->getQueue($queueName);

        return $queue->getAllMessages();
    }

    public function getMessage(string $queueName, string $messageKey): Message
    {
        $queue = $this->queues->getQueue($queueName);

        return $queue->getMessage($messageKey);
    }

    public function addQueue(string $queue): void
    {
        $this->queues->addQueue(new Queue($queue));
    }
}