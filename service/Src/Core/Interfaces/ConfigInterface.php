<?php

declare(strict_types=1);

namespace Core\Interfaces;

interface ConfigInterface {
    public function initConfigFromFile(string $fileName): bool;

    public function getConfigValue(string $key, string|array|false|null $default = null): string|array|false;
}