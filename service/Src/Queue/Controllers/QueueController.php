<?php

declare(strict_types=1);

namespace Queue\Controllers;

use Queue\Services\QueueService;

class QueueController
{
    public function __construct(
        private readonly QueueService $queueService,
    )
    {
    }

    public function getMessages(string $queue): array
    {
        return $this->queueService->getAllMessages($queue);
    }
}