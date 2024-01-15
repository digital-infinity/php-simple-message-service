<?php

declare(strict_types=1);

namespace Router\Documents;

use Closure;
use ReflectionClass;

class Route {
    private Closure $action;

    public function __construct(
        mixed $controller,
        string $method,
    ) {
        $reflection = new ReflectionClass($controller);
        $method = $reflection->getMethod($method)->getClosure($controller);
        $this->action = $method;
    }

    public function execute(array $params): mixed
    {
        return call_user_func_array($this->action, $params);
    }
}