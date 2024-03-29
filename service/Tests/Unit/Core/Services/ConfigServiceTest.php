<?php

declare(strict_types=1);

use Core\Services\ConfigService;
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
     * @dataProvider dataGetConfigValue
     */
    public function testGetConfigValue(string $key, string|array|false $expected, string|array|bool|null $default): void
    {
        if (isset($default)) {
            $actual = $this->configService->getConfigValue($key, $default);
        } else {
            $actual = $this->configService->getConfigValue($key);
        }

        $this->assertEquals($expected, $actual);
    }

    public static function dataGetConfigValue(): Generator
    {
        putenv('TEST1=VALUE');

        yield 'getConfigValue: success' => [
            'key' => 'TEST1',
            'expected' => 'VALUE',
            'default' => null,
        ];

        yield 'getConfigValue: no value found, default provided' => [
            'key' => 'TEST2',
            'expected' => 'DEFAULT',
            'default' => 'DEFAULT',
        ];

        yield 'getConfigValue: no value found, no default provided' => [
            'key' => 'TEST3',
            'expected' => false,
            'default' => null,
        ];
    }
}