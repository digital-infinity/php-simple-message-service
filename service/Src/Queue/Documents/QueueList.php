<?php

declare(strict_types=1);

namespace Queue\Documents;

use Queue\Documents\Queue;
use Queue\Exceptions\QueueNotFoundException;

class QueueList
{
    /** @var Queue[] */
    private array $queues = [];

    public function addQueue(Queue $queue): void
    {
        $this->queues[$queue->getQueueName()] = $queue;
    }

    public function getAllQueues(): array
    {
        return($this->queues);
    }

    public function getQueue(string $name): Queue
    {
        $queue = $this->queues[$name] ?? null;

        if ($queue === null) {
            throw new QueueNotFoundException(sprintf("The Queue %s was not found.", $name));
        }

        return $queue;
    }
}