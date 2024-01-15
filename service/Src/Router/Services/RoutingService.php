<?php

declare(strict_types=1);

namespace Router\Services;

use Router\Documents\Route;
use Router\Exceptions\RouteNotFoundException;

class RoutingService {
    public function __construct(private array $routes = []) 
    {
        $this->routes = $routes;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function addRoute(string $path, Route $route): void
    {
        $this->routes[$path] = $route;
    }

    public function hasRoute(string $path): bool
    {
        return isset($this->routes[$path]);
    }

    public function getRoute(string $path): Route
    {
        if (isset($this->routes[$path])) {
            return $this->routes[$path];
        }

        throw new RouteNotFoundException();
    }
}
