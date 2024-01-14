<?php

declare(strict_types=1);

namespace Router\Services;

use Router\Entities\Route;
use Router\Exceptions\RouteNotFoundException;

class RoutingService {
    private $routes = [];

    public function __construct(array $routes) 
    {
        $this->routes = $routes;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function addRoute(Route $route): void
    {
        $this->routes[] = $route;
    }

    public function hasRoute(string $name): bool
    {
        return isset($this->routes[$name]);
    }

    public function getRoute(string $name): Route
    {
        if (isset($this->routes[$name])) {
            return $this->routes[$name];
        }

        throw new RouteNotFoundException();
    }
}
