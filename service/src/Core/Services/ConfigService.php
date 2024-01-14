<?php

declare(strict_types=1);

namespace Core\Services;

class ConfigService {

    private array $config;

    public function getEnvConfigValue(string $name, string|array|false|null $default = null): string|array|false
    {
        $value = $this->getValueFromEnv($name);

        if ($value) {
            return $value;
        }

        return $default ?? false;
    }

    private function getValueFromEnv(string $name): string|array|false
    {
        return getenv($name);
    }
    
}