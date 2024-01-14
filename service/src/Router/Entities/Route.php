<?php

declare(strict_types=1);

namespace Router\Entities;

class Route {

    public function __construct(
        private string $name, 
        private string $path, 
        private string $controller, 
        private string $action, 
        private array $params = []
    ) {

    }
}