<?php

declare(strict_types= 1);

use Core\Services\ConfigService;
use phpDocumentor\Reflection\Types\Void_;
use PHPUnit\Framework\TestCase;

class ConfigServiceTest extends TestCase
{
    private ConfigService $configService;

    public function setUp(): void
    {
        $this->configService = new ConfigService();
    }

    /**
     * @covers ConfigService
     * @dataProvider dataGetEnvConfigValue
     */
    public function testGetEnvConfigValue(string $key, string|array|false $expected, string|array|bool|null $default): void
    {
        if (isset($default)) {
            $actual = $this->configService->getEnvConfigValue($key, $default);
        } else {
            $actual = $this->configService->getEnvConfigValue($key);
        }

        $this->assertEquals($expected, $actual);
    }

    public function dataGetEnvConfigValue(): Generator
    {
        putenv('TEST1=VALUE');

        yield 'getEnvConfigValue: success' => [
            'key' => 'TEST1',
            'expected' => 'VALUE',
            'default' => null,
        ];

        yield 'getEnvConfigValue: no value found, default provided' => [
            'key' => 'TEST2',
            'expected' => 'DEFAULT',
            'default' => 'DEFAULT',
        ];

        yield 'getEnvConfigValue: no value found, no default provided' => [
            'key' => 'TEST3',
            'expected' => false,
            'default' => null,
        ];
    }
}