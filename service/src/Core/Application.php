<?php

declare(strict_types=1);

namespace Core;
use Router\Services\RoutingService;

class Application
{

    public function __construct(
        private RoutingService $routingService
    ) {

    }

    public function run(): void
    {
        $uri = $_SERVER['REQUEST_URI'];        

        if($this->RoutingService->hasRoute($uri)) {
            $this->routingService->getRoute($uri);
        }
    }
}