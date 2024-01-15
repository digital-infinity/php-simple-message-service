<?php

declare(strict_types=1);

namespace Core\Services;

use Core\Interfaces\ConfigInterface;
use SplFileObject;

class ConfigService implements ConfigInterface
{

    private array $config = [];

    /**
     *  First attempt to get config from env, if not present then attempt to get from current state.
     *  Default value can be set to return in event config value not present. 
     */
    public function getConfigValue(
        string $key, 
        string|array|false|null $default = null, 
    ): string|array|false
    {
        $value = $this->getValueFromEnv($key);

        if ($value) {
            return $value;
        }

        if (isset($this->config[$key])) {
            return $this->config[$key];
        }

        return $default ?? false;
    }

    private function getValueFromEnv(string $name): string|array|false
    {
        return getenv($name);
    }

    public function initConfigFromFile(string $fileName): bool
    {
        $fileObject = new SplFileObject($fileName);

        if (!$fileObject->isReadable()) {
            return false;
        }

        while(!$fileObject->eof()) {
            $configEntryString = $fileObject->fgets();
            
            $configEntryNoWhitespace = trim($configEntryString);

            $configEntry = explode(':', $configEntryNoWhitespace);

            $this->config = array_merge($this->config, $configEntry);
        }

        return true;
    }
}