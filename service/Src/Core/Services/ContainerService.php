<?php

declare(strict_types=1);

namespace Core\Services;

use Core\Exceptions\InstanceNotFoundException;
use Psr\Container\ContainerInterface;

class ContainerService implements ContainerInterface
{
    private array $instances = [];

    public function get(string $id): object 
    {
        if (!$this->has($id)) {
            throw new InstanceNotFoundException($id);
        }

        return $this->instances[$id];
    }

    public function has(string $id): bool 
    {
        return isset($this->instances[$id]);
    }

    public function contain(string $id, object $instance): void  
    {
        $this->instances[$id] = $instance;
    }
}